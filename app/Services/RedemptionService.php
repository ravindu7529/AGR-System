<?php

namespace App\Services;

use App\Models\Redemption;

class RedemptionService
{
    public function addPointsForVisit(int $guideId, int $paxCount): Redemption
    {
        $points = $paxCount * 110;

        $redemption = Redemption::firstOrCreate(
            ['guide_id' => $guideId],
            ['points' => 0]
        );

        $redemption->points += $points;
        $redemption->save();

        return $redemption;
    }
}
