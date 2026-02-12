@extends('layouts.admin')

@section('title', 'Withdrawal Management')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Withdrawals</h1>
</div>

<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Status</th>
                <th>Details</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($withdrawals as $withdrawal)
            <tr>
                <td>{{ $withdrawal->id }}</td>
                <td>{{ $withdrawal->user->name }}</td>
                <td>${{ number_format($withdrawal->amount, 2) }}</td>
                <td>{{ $withdrawal->method }}</td>
                <td>
                    <span class="badge bg-{{ $withdrawal->status === 'approved' ? 'success' : ($withdrawal->status === 'pending' ? 'warning' : 'danger') }}">
                        {{ $withdrawal->status }}
                    </span>
                </td>
                <td><small>{{ $withdrawal->details }}</small></td>
                <td>
                    @if($withdrawal->status === 'pending')
                    <div class="btn-group">
                        <form action="{{ route('admin.withdrawals.update', $withdrawal->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="status" value="approved">
                            <button class="btn btn-success btn-sm">Approve</button>
                        </form>
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $withdrawal->id }}">
                            Reject
                        </button>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="rejectModal{{ $withdrawal->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form action="{{ route('admin.withdrawals.update', $withdrawal->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="rejected">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Reject Withdrawal</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <label>Rejection Reason</label>
                                        <textarea name="rejection_reason" class="form-control" required></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-danger">Confirm Reject</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
