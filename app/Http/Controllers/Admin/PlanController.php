<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Hosting;
use App\Models\Server;
use App\Models\EmailService;
use App\Http\Requests\PlanRequest;
use Illuminate\Http\Request;

class PlanController extends Controller
{

    public function byHosting(Request $request, Hosting $hosting)
    {
        $plans = Plan::where('common_id', $hosting->id)
            ->where('common_type', Hosting::class)
            ->orderBy('sort_order')
            ->paginate(10);

        $nextSortOrder = (Plan::where('common_id', $hosting->id)
            ->where('common_type', Hosting::class)
            ->max('sort_order') ?? 0) + 1;

        $server = null;
        $emailService = null;

        return view('admin.plan.index', compact('plans', 'hosting', 'nextSortOrder', 'server', 'emailService'));
    }

    public function byServer(Request $request, Server $server)
    {
        $plans = Plan::where('common_id', $server->id)
            ->where('common_type', Server::class)
            ->orderBy('sort_order')
            ->paginate(10);

        $nextSortOrder = (Plan::where('common_id', $server->id)
            ->where('common_type', Server::class)
            ->max('sort_order') ?? 0) + 1;

        $hosting = null;
        $emailService = null;

        return view('admin.plan.index', compact('plans', 'server', 'nextSortOrder', 'hosting', 'emailService'));
    }

    public function byEmailService(Request $request, EmailService $emailService)
    {
        $plans = Plan::where('common_id', $emailService->id)
            ->where('common_type', EmailService::class)
            ->orderBy('sort_order')
            ->paginate(10);

        $nextSortOrder = (Plan::where('common_id', $emailService->id)
            ->where('common_type', EmailService::class)
            ->max('sort_order') ?? 0) + 1;

        $hosting = null;
        $server = null;

        return view('admin.plan.index', compact('plans', 'emailService', 'nextSortOrder', 'hosting', 'server'));
    }

    public function index(Request $request)
    {
        $plans = Plan::when($request->search, function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%');
        })
        ->orderBy('sort_order')
        ->paginate(10);

        $nextSortOrder = (Plan::max('sort_order') ?? 0) + 1;
        $hosting = null;
        $server = null;

        return view('admin.plan.index', compact('plans', 'nextSortOrder', 'hosting', 'server'));
    }


    public function create()
    {
        $nextSortOrder = (Plan::max('sort_order') ?? 0)+1;
        $plans = Plan::orderBy('sort_order')->paginate(10);
        $hosting = null;
        $server = null;

        return view('admin.plan.index', compact('nextSortOrder', 'plans', 'hosting', 'server'));
    }


    public function store(PlanRequest $request)
    {
        $data = $request->validated();

        $data['offer_percentage'] = !empty($data['offer_percentage']) ? (int) $data['offer_percentage'] : 0;

        $data['sort_order'] ??= (Plan::where('common_id', $data['common_id'])
            ->where('common_type', $data['common_type'])
            ->max('sort_order') ?? 0) + 1;

        $data['is_active'] = (bool) $request->input('is_active', 0);

        Plan::create($data);

        return back()->with('success', 'Plan Added Successfully');
    }


    public function edit(Plan $plan, Request $request)
    {
        $editPlan = $plan;
        $plans = Plan::where('common_id', $plan->common_id)
            ->where('common_type', $plan->common_type)
            ->orderBy('sort_order')
            ->paginate(10);

        $nextSortOrder = $plan->sort_order;

        // Hosting context via ?hosting=id
        $hosting = null;
        if ($request->query('hosting')) {
            $hosting = Hosting::find($request->query('hosting'));
        }

        // Server context via ?server=id
        $server = null;
        if ($request->query('server')) {
            $server = Server::find($request->query('server'));
        }

        // EmailService context via ?email_service=id or model
        $emailService = null;
        if ($request->query('email_service')) {
            $emailService = EmailService::find($request->query('email_service'));
        } elseif ($plan->common_type === EmailService::class) {
            $emailService = EmailService::find($plan->common_id);
        }

        return view('admin.plan.index', compact('editPlan', 'plans', 'nextSortOrder', 'hosting', 'server', 'emailService'));
    }


    public function update(PlanRequest $request, Plan $plan)
    {
        $data = $request->validated();

        $data['offer_percentage'] = !empty($data['offer_percentage']) ? (int) $data['offer_percentage'] : 0;
        $data['is_active'] = (bool) $request->input('is_active', 0);

        $plan->update($data);

        return back()->with('success', 'Plan Updated Successfully');
    }


    public function destroy(Plan $plan)
    {
        $plan->delete();

        return back()->with('success','Plan Deleted Successfully');
    }

    public function toggleStatus(Plan $plan)
    {
        $plan->is_active = !$plan->is_active;
        $plan->save();

        return response()->json([
            'success' => true,
            'is_active' => $plan->is_active,
            'message' => 'Plan status updated successfully.'
        ]);
    }

}
