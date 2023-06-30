<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\Terminal;
use Cjmellor\Approval\Enums\ApprovalStatus;
use Illuminate\Http\Request;

class Approvals extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Approval::class);
    }

    public function index()
    {
        return view('pages.approvals.index');
    }

    public function update(Approval $approval)
    {
        $modelClass = $approval->approvalable_type;

        $modelId = $approval->approvalable_id;

        $model = new $modelClass();

        if ($modelId) {
            $model = $model->find($modelId);
        }

        $model->fill($approval->new_data->toArray());

        $model->withoutApproval()->save();

        if ($model instanceof  Terminal) {
            TerminalProcessor::createForTerminal($model);
        }

        $approval->update(['state' => ApprovalStatus::Approved]);

        return back()->with('success', "Approval successful! $approval->resource $approval->action.");
    }

    public function destroy(Approval $approval)
    {
        $approval->reject();

        return back()->with('success', "Approval rejected! $approval->resource NOT $approval->action.");
    }
}
