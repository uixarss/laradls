<div class="card mb-5 mb-lg-10">
    <div class="card-header">
        <div class="card-title">
            <h3>Log</h3>
        </div>

    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-flush align-middle table-row-bordered table-row-solid gy-4 gs-9">
                <thead class="border-gray-200 fs-5 fw-bold bg-lighten">
                    <tr>
                        <th class="min-w-100px">IP</th>
                        <th class="min-w-100px">Pengguna</th>
                        <th class="min-w-250px">Deskripsi</th>
                        <th class="min-w-150px">Waktu</th>
                    </tr>
                </thead>
                <tbody class="fw-6 fw-bold text-gray-600">
                    @foreach ($data_log as $log)
                    <tr>
                        <td>
                            <div class="d-flex flex-column">
                                <a href="#"" class=" text-gray-800 text-hover-primary mb-1">
                                    {{ $log->properties['ip'] ?? ''}}
                                </a>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <a href="#" class="text-gray-800 text-hover-primary mb-1">
                                    {{ $log->causer->name }}
                                </a>
                            </div>
                        </td>
                        <td>
                            {{ $log->description }}
                        </td>
                        <td>{{ \Carbon\Carbon::parse($log->created_at)->format('d M Y H:i A') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>