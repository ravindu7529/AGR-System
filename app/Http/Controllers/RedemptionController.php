<?php

// app/Http/Controllers/RedemptionController.php

namespace App\Http\Controllers;

use App\Models\Redemption;
use App\Models\Guide;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Item;
use Illuminate\Support\Facades\Log;

class RedemptionController extends Controller
{
    // Update the store method in RedemptionController.php
    public function store(Request $request, $guide_id)
    {
        $request->validate([
            'item_ids' => 'required|array|min:1',
            'item_ids.*' => 'exists:items,id',
        ]);

        $guide = Guide::findOrFail($guide_id);
        $items = Item::whereIn('id', $request->item_ids)->get();
        $totalPoints = $items->sum('points');

        // Find the existing redemption row for this guide
        $redemption = Redemption::where('guide_id', $guide_id)->first();

        if (!$redemption) {
            // If no row exists, create one with the guide's starting points
            $redemption = Redemption::create([
                'guide_id' => $guide_id,
                'points' => $guide->earned_points,
                'reserved_points' => 0,
                'redeemed_at' => now(),
            ]);
        }

        // Calculate available points (total points - reserved points)
        $availablePoints = $redemption->points - $redemption->reserved_points;
        $minPointsToLeave = 10;
        $maxRedeemable = max($availablePoints - $minPointsToLeave, 0);

        if ($maxRedeemable <= 0) {
            return response()->json([
                'message' => "You need at least 11 points to redeem. You currently have only $availablePoints available points."
            ], 400);
        }

        if ($totalPoints > $maxRedeemable) {
            return response()->json([
                'message' => "You only have $availablePoints available points. You can redeem up to $maxRedeemable points worth of items."
            ], 400);
        }

        // RESERVE the points immediately when request is created
        $redemption->reserved_points += $totalPoints;
        $redemption->save();

        $redemptionRequest = \App\Models\RedemptionRequest::create([
            'guide_id' => $guide_id,
            'item_ids' => $request->item_ids,
            'item_details' => $items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'points' => $item->points
                ];
            })->toArray(),
            'total_points' => $totalPoints,
            'status' => 'pending'
        ]);

        return response()->json([
            'message' => 'Redemption request submitted successfully. Points are reserved pending admin approval.',
            'request_id' => $redemptionRequest->id,
            'status' => 'pending',
            'reserved_points' => $totalPoints,
            'available_points' => $redemption->points - $redemption->reserved_points
        ]);
    }

    // Update the approveRequest method
    public function approveRequest(Request $request, $requestId)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'admin_notes' => 'nullable|string|max:500'
        ]);

        $redemptionRequest = \App\Models\RedemptionRequest::findOrFail($requestId);
        
        if ($redemptionRequest->status !== 'pending') {
            return response()->json([
                'message' => 'This request has already been processed.'
            ], 400);
        }

        $guide = $redemptionRequest->guide;
        $action = $request->action;

        // Get the authenticated admin
        $admin = auth('sanctum')->user();
        $adminId = $admin ? $admin->id : null;

        $redemption = Redemption::where('guide_id', $redemptionRequest->guide_id)->first();

        if ($action === 'approve') {
            // Convert reserved points to actual deduction
            $redemption->points -= $redemptionRequest->total_points;
            $redemption->reserved_points -= $redemptionRequest->total_points;
            $redemption->redeemed_at = now();
            $redemption->save();

            // Update request status
            $redemptionRequest->update([
                'status' => 'approved',
                'approved_by' => $adminId,
                'approved_at' => now(),
                'admin_notes' => $request->admin_notes
            ]);

            // Send WhatsApp approval message
            $this->sendApprovalMessage($guide, $redemptionRequest->item_details);

            return response()->json([
                'message' => 'Redemption request approved successfully. Points have been deducted.',
                'redemption' => $redemption
            ]);

        } else {
            // RESTORE reserved points on rejection
            $redemption->reserved_points -= $redemptionRequest->total_points;
            $redemption->save();

            // Update request status
            $redemptionRequest->update([
                'status' => 'rejected',
                'approved_by' => $adminId,
                'approved_at' => now(),
                'admin_notes' => $request->admin_notes
            ]);

            // Send WhatsApp rejection message
            $this->sendRejectionMessage($guide, $request->admin_notes);

            return response()->json([
                'message' => 'Redemption request rejected. Reserved points have been restored.',
                'available_points' => $redemption->points - $redemption->reserved_points
            ]);
        }
    }

    // Add method to send approval WhatsApp message
    private function sendApprovalMessage($guide, $itemDetails)
    {
        try {
            $twilio = new \Twilio\Rest\Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

            $mobile = $guide->mobile_number;
            if (strpos($mobile, '+') !== 0) {
                $mobile = '+94' . ltrim($mobile, '0');
            }

            $itemNames = array_column($itemDetails, 'name');
            $itemList = implode(', ', $itemNames);

            $twilio->messages->create(
                'whatsapp:' . $mobile,
                [
                    'from' => env('TWILIO_WHATSAPP_FROM'),
                    'contentSid' => 'HXa265a3ead6889d9f10cbc576f34c4373',
                    'contentVariables' => json_encode([ 
                        '1' => $itemList                     
                    ]),
                ]
            );
        } catch (\Exception $e) {
            Log::error('WhatsApp approval notification failed: ' . $e->getMessage());
        }
    }

    // Add method to send rejection WhatsApp message
    private function sendRejectionMessage($guide, $reason)
    {
        try {
            $twilio = new \Twilio\Rest\Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

            $mobile = $guide->mobile_number;
            if (strpos($mobile, '+') !== 0) {
                $mobile = '+94' . ltrim($mobile, '0');
            }

            $twilio->messages->create(
                'whatsapp:' . $mobile,
                [
                    'from' => env('TWILIO_WHATSAPP_FROM'),
                    'contentSid' => 'HXf5985c2713ab6fbdd3a939f888cbced0',
                    'contentVariables' => json_encode([
                        '1' => $reason ? $reason : 'No reason provided'
                    ]),
                ]
            );
        } catch (\Exception $e) {
            Log::error('WhatsApp rejection notification failed: ' . $e->getMessage());
        }
    }

    // Get all redemption requests for admin
    public function getPendingRequests()
    {
        $requests = \App\Models\RedemptionRequest::with('guide')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'requests' => $requests
        ]);
    }

    public function history($guideId)
    {
        return Redemption::where('guide_id', $guideId)->orderByDesc('redeemed_at')->get();
    }

    /**
     * Redeem points for cash
     */
    // Add these methods to RedemptionController.php

    /**
     * Redeem points for cash - Create request instead of immediate redemption
     */
    public function redeemCash(Request $request, $guide_id)
    {
        $request->validate([
            'amount' => 'required|integer|min:1',
        ]);

        $guide = Guide::findOrFail($guide_id);
        $amount = $request->amount;

        // Find the existing redemption row for this guide
        $redemption = Redemption::where('guide_id', $guide_id)->first();

        if (!$redemption) {
            // If no row exists, create one with the guide's starting points
            $redemption = Redemption::create([
                'guide_id' => $guide_id,
                'points' => $guide->earned_points,
                'reserved_points' => 0,
                'redeemed_at' => now(),
            ]);
        }

        // Calculate available points (total points - reserved points)
        $availablePoints = $redemption->points - $redemption->reserved_points;

        // Check if guide has enough available points
        if ($amount > $availablePoints) {
            return response()->json([
                'message' => "Insufficient points. You have $availablePoints points available (some points may be reserved for pending requests)."
            ], 400);
        }

        // RESERVE the points immediately when cash request is created
        $redemption->reserved_points += $amount;
        $redemption->save();

        $cashRedemptionRequest = \App\Models\CashRedemptionRequest::create([
            'guide_id' => $guide_id,
            'amount' => $amount,
            'status' => 'pending'
        ]);

        return response()->json([
            'message' => 'Cash redemption request submitted successfully. Points are reserved pending admin approval.',
            'request_id' => $cashRedemptionRequest->id,
            'amount' => $amount,
            'status' => 'pending',
            'reserved_points' => $amount,
            'available_points' => $redemption->points - $redemption->reserved_points
        ]);
    }

    /**
     * Approve or reject cash redemption request
     */
    public function approveCashRequest(Request $request, $requestId)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'admin_notes' => 'nullable|string|max:500'
        ]);

        $cashRedemptionRequest = \App\Models\CashRedemptionRequest::findOrFail($requestId);
        
        if ($cashRedemptionRequest->status !== 'pending') {
            return response()->json([
                'message' => 'This request has already been processed.'
            ], 400);
        }

        $guide = $cashRedemptionRequest->guide;
        $action = $request->action;

        // Get the authenticated admin
        $admin = auth('sanctum')->user();
        $adminId = $admin ? $admin->id : null;

        $redemption = Redemption::where('guide_id', $cashRedemptionRequest->guide_id)->first();

        if ($action === 'approve') {
            // Convert reserved points to actual deduction
            $redemption->points -= $cashRedemptionRequest->amount;
            $redemption->reserved_points -= $cashRedemptionRequest->amount;
            $redemption->redeemed_at = now();
            $redemption->save();

            // Update request status
            $cashRedemptionRequest->update([
                'status' => 'approved',
                'approved_by' => $adminId,
                'approved_at' => now(),
                'admin_notes' => $request->admin_notes
            ]);

            // Send WhatsApp approval message for cash
            $this->sendCashApprovalMessage($guide, $cashRedemptionRequest->amount, $redemption->points);

            return response()->json([
                'message' => 'Cash redemption request approved successfully. Points have been deducted.',
                'redemption' => $redemption
            ]);

        } else {
            // RESTORE reserved points on rejection
            $redemption->reserved_points -= $cashRedemptionRequest->amount;
            $redemption->save();

            // Update request status
            $cashRedemptionRequest->update([
                'status' => 'rejected',
                'approved_by' => $adminId,
                'approved_at' => now(),
                'admin_notes' => $request->admin_notes
            ]);

            // Send WhatsApp rejection message for cash
            $this->sendCashRejectionMessage($guide, $request->admin_notes);

            return response()->json([
                'message' => 'Cash redemption request rejected. Reserved points have been restored.',
                'available_points' => $redemption->points - $redemption->reserved_points
            ]);
        }
    }

    /**
     * Get all cash redemption requests for admin
     */
    public function getPendingCashRequests()
    {
        $requests = \App\Models\CashRedemptionRequest::with('guide')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'cash_requests' => $requests
        ]);
    }

    /**
     * Send WhatsApp approval message for cash redemption
     */
    private function sendCashApprovalMessage($guide, $amount, $remainingPoints)
    {
        try {
            $twilio = new \Twilio\Rest\Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

            $mobile = $guide->mobile_number;
            if (strpos($mobile, '+') !== 0) {
                $mobile = '+94' . ltrim($mobile, '0');
            }

            $twilio->messages->create(
                'whatsapp:' . $mobile,
                [
                    'from' => env('TWILIO_WHATSAPP_FROM'),
                    'contentSid' => 'HXd79234b801be221fac7c71a031f22b7a', // Your existing cash template
                    'contentVariables' => json_encode([
                        '1' => $guide->full_name,
                        '2' => number_format($amount),
                        '3' => number_format($amount),
                        '4' => number_format($remainingPoints)
                    ]),
                ]
            );
        } catch (\Exception $e) {
            Log::error('WhatsApp cash approval notification failed: ' . $e->getMessage());
        }
    }

    /**
     * Send WhatsApp rejection message for cash redemption
     */
    private function sendCashRejectionMessage($guide, $reason)
    {
        try {
            $twilio = new \Twilio\Rest\Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

            $mobile = $guide->mobile_number;
            if (strpos($mobile, '+') !== 0) {
                $mobile = '+94' . ltrim($mobile, '0');
            }

            $twilio->messages->create(
                'whatsapp:' . $mobile,
                [
                    'from' => env('TWILIO_WHATSAPP_FROM'),
                    'contentSid' => 'HX95836d887c1b3e5d749930abf829d944', // Your existing cash template
                    'contentVariables' => json_encode([
                        '1' => $reason ? $reason : 'No reason provided'
                    ]),
                ]
            );
        } catch (\Exception $e) {
            Log::error('WhatsApp cash rejection notification failed: ' . $e->getMessage());
        }
    }

    /**
     * Show the redemption details for a specific guide.
     */

    public function show($id)
    {
        $redemption = \App\Models\Redemption::where('guide_id', $id)->first();

        if (!$redemption) {
            return response()->json(['message' => 'Redemption not found'], 404);
        }

        return response()->json([
            'redemption' => $redemption
        ]);
    }
}
