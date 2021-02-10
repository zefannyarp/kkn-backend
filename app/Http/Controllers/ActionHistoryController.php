<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\KepalaKeluarga;
use App\Models\AnggotaKeluarga;
use App\Models\ActionHistory;

class ActionHistoryController extends Controller
{
    public function editAction($id, Request $request, ActionHistory $actionHistory) {
        $tujuan_asal = $request->input('tujuan_asal');
        $alasan = $request->input('alasan');

        $actionHistory = ActionHistory::findOrFail($id);
        $actionHistory->update([
            $actionHistory->setAttribute(ActionHistory::ATTRIBUTE_TUJUAN_ASAL, $tujuan_asal),
            $actionHistory->setAttribute(ActionHistory::ATTRIBUTE_ALASAN, $alasan)
        ]);

        return response()->json($actionHistory, 200);
    }

    public function showHistory (ActionHistory $actionHistory) {
        return ActionHistory::all();
    }

    public function getActionHistory($id) {
        return ActionHistory::findOrFail($id);
    }

}
