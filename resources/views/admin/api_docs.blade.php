@extends('layouts.admin')

@section('title', 'REST API Explorer & Tester')
@section('page_title', 'REST API Sandbox & Dokumentasi')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Developer</a></li>
    <li class="breadcrumb-item active">REST API</li>
@endsection

@section('content')
<!-- Header Info Card -->
<div class="card bg-gradient-dark text-white shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge badge-info px-2 py-1 mb-2 font-weight-bold">REST API V1 ACTIVE</span>
                <h3 class="font-weight-bold mb-1">U.N.O E-Commerce API Hub</h3>
                <p class="text-white-50 mb-2">Endpoint RESTful standar terenkripsi JSON untuk integrasi Web Frontend, Admin Dashboard, dan Aplikasi Mobile React Native / Expo.</p>
                <div class="d-flex align-items-center">
                    <span class="text-warning mr-3 font-monospace"><i class="fas fa-server mr-1"></i> Base URL: <strong>{{ $baseUrl }}</strong></span>
                    <span class="badge badge-success px-2 py-1"><i class="fas fa-signal mr-1"></i> Server IP: {{ $serverIp }}</span>
                </div>
            </div>
            <div class="col-lg-4 text-lg-right mt-3 mt-lg-0">
                <button type="button" class="btn btn-outline-light font-weight-bold" onclick="pingServer()">
                    <i class="fas fa-heartbeat mr-1"></i> Cek Koneksi / Ping
                </button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Endpoints List Accordion -->
    <div class="col-lg-7">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title font-weight-bold text-dark">
                    <i class="fas fa-list-alt mr-1 text-primary"></i> Daftar Endpoint REST API
                </h3>
            </div>
            <div class="card-body p-0">
                <div class="accordion" id="apiAccordion">
                    @foreach($endpoints as $idx => $group)
                    <div class="card mb-0 border-top-0 border-right-0 border-left-0 rounded-0">
                        <div class="card-header bg-light py-2" id="heading-{{ $idx }}">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left text-dark font-weight-bold d-flex justify-content-between align-items-center" type="button" data-toggle="collapse" data-target="#collapse-{{ $idx }}" aria-expanded="{{ $idx === 0 ? 'true' : 'false' }}">
                                    <span><i class="fas fa-folder-open text-primary mr-2"></i> {{ $group['group'] }}</span>
                                    <span class="badge badge-secondary badge-pill">{{ count($group['items']) }} endpoints</span>
                                </button>
                            </h2>
                        </div>

                        <div id="collapse-{{ $idx }}" class="collapse {{ $idx === 0 ? 'show' : '' }}" data-parent="#apiAccordion">
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush">
                                    @foreach($group['items'] as $ep)
                                    <div class="list-group-item p-3 d-flex justify-content-between align-items-center hover-bg">
                                        <div style="max-width: 75%;">
                                            <div class="d-flex align-items-center mb-1">
                                                <span class="badge {{ $ep['method'] === 'GET' ? 'badge-success' : ($ep['method'] === 'POST' ? 'badge-primary' : ($ep['method'] === 'PUT' ? 'badge-warning' : 'badge-danger')) }} mr-2 font-monospace px-2 py-1 font-weight-bold" style="font-size: 11px;">
                                                    {{ $ep['method'] }}
                                                </span>
                                                <code class="text-dark font-weight-bold">{{ $ep['url'] }}</code>
                                                @if($ep['auth'])
                                                    <span class="badge badge-light border text-xs ml-2 text-muted" title="Memerlukan Bearer Token"><i class="fas fa-lock text-warning"></i> Auth</span>
                                                @endif
                                            </div>
                                            <div class="text-muted text-xs">{{ $ep['desc'] }}</div>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-xs btn-outline-primary font-weight-bold" 
                                                    onclick="loadTester('{{ $ep['method'] }}', '{{ $ep['url'] }}', '{{ addslashes($ep['body'] ?? '') }}')">
                                                Test <i class="fas fa-play text-xs ml-1"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Live Tester Column -->
    <div class="col-lg-5">
        <div class="card card-outline card-primary shadow-sm sticky-top" style="top: 80px;">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h3 class="card-title font-weight-bold text-dark">
                    <i class="fas fa-vial mr-1 text-primary"></i> Live Request Sandbox
                </h3>
                <span id="responseStatusBadge" class="badge badge-light border">Menunggu Eksekusi</span>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="text-xs text-muted font-weight-bold mb-1">METHOD & ENDPOINT</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <select id="reqMethod" class="custom-select font-weight-bold text-xs" style="max-width: 90px;">
                                <option value="GET">GET</option>
                                <option value="POST">POST</option>
                                <option value="PUT">PUT</option>
                                <option value="PATCH">PATCH</option>
                                <option value="DELETE">DELETE</option>
                            </select>
                        </div>
                        <input type="text" id="reqUrl" class="form-control font-monospace text-sm" value="/v1/categories">
                    </div>
                </div>

                <div class="form-group">
                    <label class="text-xs text-muted font-weight-bold mb-1">BEARER TOKEN (OPSIONAL / AUTO ADMIN)</label>
                    <input type="text" id="reqToken" class="form-control form-control-sm font-monospace text-xs" placeholder="Bearer Token (kosongkan untuk public)">
                </div>

                <div class="form-group" id="bodyGroup" style="display: none;">
                    <label class="text-xs text-muted font-weight-bold mb-1">JSON REQUEST BODY</label>
                    <textarea id="reqBody" class="form-control font-monospace text-xs" rows="3" placeholder='{"key": "value"}'></textarea>
                </div>

                <button type="button" class="btn btn-primary btn-block font-weight-bold" onclick="executeApiTest()">
                    <i class="fas fa-paper-plane mr-1"></i> Kirim Request
                </button>

                <hr>

                <div class="form-group mb-0">
                    <label class="text-xs text-muted font-weight-bold d-flex justify-content-between">
                        <span>RESPONSE PREVIEW</span>
                        <span id="responseTime" class="text-muted font-weight-normal text-xs">-</span>
                    </label>
                    <pre id="responseOutput" class="bg-dark text-success p-3 rounded text-xs font-monospace mb-0" style="max-height: 280px; overflow-y: auto;">Klik tombol "Test" atau "Kirim Request" untuk melihat data JSON live dari REST API.</pre>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const baseUrl = '{{ $baseUrl }}';

    function loadTester(method, url, body) {
        document.getElementById('reqMethod').value = method;
        document.getElementById('reqUrl').value = url;
        
        let bodyGroup = document.getElementById('bodyGroup');
        let bodyInput = document.getElementById('reqBody');
        
        if (method !== 'GET') {
            bodyGroup.style.display = 'block';
            bodyInput.value = body || '{}';
        } else {
            bodyGroup.style.display = 'none';
            bodyInput.value = '';
        }

        executeApiTest();
    }

    function pingServer() {
        fetch('/api/health')
            .then(res => res.json())
            .then(data => {
                Toast.fire({
                    icon: 'success',
                    title: 'Server API Online: ' + data.server_ip
                });
            })
            .catch(err => {
                Toast.fire({
                    icon: 'error',
                    title: 'Gagal terhubung ke API Server'
                });
            });
    }

    function executeApiTest() {
        let method = document.getElementById('reqMethod').value;
        let endpoint = document.getElementById('reqUrl').value;
        let token = document.getElementById('reqToken').value.trim();
        let bodyContent = document.getElementById('reqBody').value.trim();
        let out = document.getElementById('responseOutput');
        let badge = document.getElementById('responseStatusBadge');
        let timeLabel = document.getElementById('responseTime');

        out.innerText = 'Mengirim request ke ' + baseUrl + endpoint + '...';
        badge.className = 'badge badge-warning text-dark';
        badge.innerText = 'Loading...';

        let headers = {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        };

        if (token) {
            headers['Authorization'] = 'Bearer ' + token;
        }

        let options = {
            method: method,
            headers: headers
        };

        if (method !== 'GET' && method !== 'HEAD' && bodyContent) {
            try {
                options.body = JSON.stringify(JSON.parse(bodyContent));
            } catch (e) {
                options.body = bodyContent;
            }
        }

        let startTime = performance.now();

        fetch('/api' + endpoint, options)
            .then(async response => {
                let endTime = performance.now();
                let duration = Math.round(endTime - startTime);
                timeLabel.innerText = duration + ' ms';

                let data;
                try {
                    data = await response.json();
                } catch(e) {
                    data = await response.text();
                }

                badge.innerText = 'HTTP ' + response.status;
                badge.className = 'badge ' + (response.ok ? 'badge-success' : 'badge-danger');
                out.innerText = typeof data === 'object' ? JSON.stringify(data, null, 2) : data;
            })
            .catch(err => {
                badge.className = 'badge badge-danger';
                badge.innerText = 'Request Failed';
                out.innerText = 'Error: ' + err.message;
            });
    }
</script>
@endsection
