<x-app-layout>
    <section class="uk-margin-medium">
        <div class="uk-container">
            <div class="rz-panel">
                <h3>Sales Order - Draft</h3>
                <div class="uk-child-width-1-2@s uk-grid-large" uk-grid>
                    <div>
                        <table class="rz-table-vertical">
                            <tr>
                                <th>No. Pesanan</th>
                                <td class="uk-table-shrink">:</td>
                                <td>{{ $pesanan['nomor'] }}</td>
                            </tr>
                            <tr>
                                <th>Customer</th>
                                <td class="uk-table-shrink">:</td>
                                <td>{{ $pesanan['customer']['nama'] }}</td>
                            </tr>
                            <tr>
                                <th>Sales</th>
                                <td class="uk-table-shrink">:</td>
                                <td>{{ $pesanan['sales_man']['nama'] ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Catatan Pembayaran</th>
                                <td>:</td>
                                <td>-</td>
                            </tr>
                        </table>
                    </div>
                    <div>
                        <table class="rz-table-vertical">
                            <tr>
                                <th>Target Pesanan</th>
                                <td class="uk-table-shrink">:</td>
                                <td>{{ date_format(date_create($pesanan['target_pesanan']), 'd-M-y') }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td class="uk-table-shrink">:</td>
                                <td>{{ $pesanan['status']['keterangan'] ?? '-' }}
                                </td>
                            </tr>

                        </table>
                    </div>


                </div>
                <div class="uk-overflow-auto uk-margin-medium-top">
                    <h4>Detail Barang</h4>
                    <table class="uk-table uk-table-small uk-table-striped">
                        <thead>
                            <tr>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Grm</th>
                                <th>Lbr</th>
                                <th>Warna</th>
                                <th>Qty Est.</th>
                                <th>Stn</th>
                                <th>Harga</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody class="uk-text-small">
                            @php
                            $total = 0;
                            @endphp
                            @foreach ($pesanan['details'] as $item)
                            @php
                            if ($item['satuan'] == 'KG') {
                            // $dharga = $item['tipe_kain']['harga_ecer'];
                            $dharga = $item['harga'];
                            } else {
                            // $dharga = $item['tipe_kain']['harga_roll'];
                            $dharga = $item['harga'];
                            }

                            if ($item['satuan'] == 'KG') {
                            $subtotal1 = $item['qty_act'] * $dharga;
                            } elseif ($item['satuan'] == 'ROLL') {
                            $subtotal1 = $item['qty_act'] * $dharga;
                            } elseif ($item['satuan'] == 'LOT') {
                            $subtotal1 = $item['qty_act'] * (12 * 25) * $dharga;
                            } else {
                            $subtotal1 = $item['qty_act'] * $dharga;
                            }


                            if (isset($item['qty_act'])) {
                            if ($item['qty_act'] >= 0) {
                            $qtyna = $item['qty_act'];
                            } else {
                            $qtyna = $item['qty'];
                            }
                            }else{

                            $qtyna = $item['qty'];
                            }

                            $subtotal = $subtotal1 - ($subtotal1 * $item['total_disc']) / 100;
                            $total += $subtotal;
                            $jum_qty = $qtyna;

                            // $harga = $item['harga'] == 0 ? $item['tipe_kain']['harga_final'] : $item['harga'];
                            // $subtotal = ($item['qty'] ?? 0) * $harga;
                            // $total += $subtotal;

                            @endphp
                            <tr>
                                <td>{{ $item['tipe_kain']['kode'] }}</td>
                                <td>{{ $item['tipe_kain']['nama'] }}</td>
                                <td>{{ $item['tipe_kain']['gramasi']['nama'] }}</td>
                                <td>{{ $item['tipe_kain']['lebar']['keterangan'] }}</td>
                                <td>{{ $item['warna_pesanan']['nama'] }}</td>
                                <td>{{ $jum_qty }}</td>
                                <td>{{ $item['satuan'] }}</td>
                                <td>
                                    @if ($pesanan['status']['kode'] == 'STS01')
                                    {{ '-' }}
                                    @else
                                    {{ number_format($dharga) }}
                                    @endif
                                </td>
                                <td class="uk-text-right">
                                    @if ($pesanan['status']['kode'] == 'STS01')
                                    {{ '-' }}
                                    @else
                                    {{ number_format($subtotal) }}
                                    @endif
                                </td>
                            </tr>
                            @endforeach


                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7"></td>
                                <td>Total</td>
                                <td class="uk-text-right">
                                    @if ($pesanan['status']['kode'] == 'STS01')
                                    {{ '-' }}
                                    @else
                                    {{ number_format($total) }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7"></td>
                                <td>DP</td>
                                <td class="uk-text-right">
                                    @if ($pesanan['status']['kode'] == 'STS01')
                                    {{ '-' }}
                                    @else
                                    {{ number_format($pesanan['dp']) ?? 0 }}
                                    @endif

                                </td>
                            </tr>
                            <tr>
                                <td colspan="7"></td>
                                <td>Grand Total</td>
                                <td class="uk-text-right">
                                    @php
                                    $grand_total = $total - ($pesanan['dp'] ?? 0);
                                    @endphp
                                    @if ($pesanan['status']['kode'] == 'STS01')
                                    {{ '-' }}
                                    @else
                                    {{ number_format($grand_total) }}
                                    @endif
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="uk-margin-medium uk-width-1-2@m">
                    <label class="uk-form-label">Jenis Pesanan:</label>
                    <div class="uk-form-controls">
                        {{ $pesanan['jenis_pesanan'] ?? '-' }}
                    </div>
                    <form action="{{ route('draft.update', $pesanan['id']) }}" method="post">
                        @csrf
                        @method('PATCH')
                        @if ($pesanan['status_pesanan_id'] == 1 && $pesanan['status_kode'] == 'Approved')
                        <div id="pesanan2" class="uk-margin">
                            <div class="uk-margin-medium-top">
                                <canvas id="sig-canvas" width="620" height="160">
                                    Please get a better browser.
                                </canvas>
                                <input type="text" name="ttd" id="sig-dataUrl" hidden>
                                <input type="text" name="nomor" value="{{ $pesanan['nomor'] }}" hidden>
                                <button type="button" id="sig-clearBtn" hidden>clear</button>
                                <button type="submit" id="sig-submitBtn" class="uk-button uk-border-rounded uk-button-primary uk-margin-top">Approve
                                    Draft</button>

                            </div>
                        </div>
                        @endif
                        @if ($pesanan['status_pesanan_id'] == 2)
                        <div class="uk-margin-medium">
                            <a href="{{ route('pesanan.checkout', $pesanan['id']) }}" class="uk-button uk-border-rounded uk-button-primary">Lanjutkan Pesanan</a>
                        </div>
                        @endif
                    </form>

                    <div class="uk-margin-medium">
                        <button class="uk-button uk-border-rounded uk-button-primary" onclick="showModal()">Batalkan
                            Pesanan</button>
                    </div>

                    <div id="myModal" uk-modal>
                        <div class="uk-modal-dialog uk-modal-body uk-border-rounded">
                            <button class="uk-modal-close-default" type="button" uk-close></button>
                            <h2 class="uk-modal-title uk-text-center">Batalkan Pesanan</h2>
                            <form action="{{ route('pesanan.batal.proses', ['id' => $pesanan->id]) }}" method="POST">
                                @csrf
                                <div class="uk-margin uk-text-left">
                                    <label class="uk-form-label">Alasan Pembatalan:</label>
                                    <div class="uk-form-controls">
                                        <select class="uk-select" id="alasan" name="alasan" required>
                                            <option value="Harga Tidak Cocok,">Harga Tidak Cocok</option>
                                            <option value="Target Pesanan Lama,">Target Pesanan Lama</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="uk-margin uk-text-left">
                                    <label class="uk-form-label">Keterangan:</label>
                                    <div class="uk-form-controls">
                                        <textarea id="keterangan" name="keterangan" class="uk-textarea"></textarea>
                                    </div>
                                </div>
                                <div class="uk-text-right">
                                    <button class="uk-button uk-border-rounded uk-button-default uk-modal-close" type="button">Batal</button>
                                    <button type="submit" class="uk-button uk-border-rounded uk-button-primary uk-margin-small" onclick="submitForm()">Konfirmasi</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('script')
    <script>
        (function() {
            window.requestAnimFrame = (function(callback) {
                return window.requestAnimationFrame ||
                    window.webkitRequestAnimationFrame ||
                    window.mozRequestAnimationFrame ||
                    window.oRequestAnimationFrame ||
                    window.msRequestAnimaitonFrame ||
                    function(callback) {
                        window.setTimeout(callback, 1000 / 60);
                    };
            })();

            var canvas = document.getElementById("sig-canvas");
            var ctx = canvas.getContext("2d");
            ctx.strokeStyle = "#222222";
            ctx.lineWidth = 4;

            var drawing = false;
            var mousePos = {
                x: 0,
                y: 0
            };
            var lastPos = mousePos;

            canvas.addEventListener("mousedown", function(e) {
                drawing = true;
                lastPos = getMousePos(canvas, e);
            }, false);

            canvas.addEventListener("mouseup", function(e) {
                drawing = false;
            }, false);

            canvas.addEventListener("mousemove", function(e) {
                mousePos = getMousePos(canvas, e);
            }, false);

            // Add touch event support for mobile
            canvas.addEventListener("touchstart", function(e) {

            }, false);

            canvas.addEventListener("touchmove", function(e) {
                var touch = e.touches[0];
                var me = new MouseEvent("mousemove", {
                    clientX: touch.clientX,
                    clientY: touch.clientY
                });
                canvas.dispatchEvent(me);
            }, false);

            canvas.addEventListener("touchstart", function(e) {
                mousePos = getTouchPos(canvas, e);
                var touch = e.touches[0];
                var me = new MouseEvent("mousedown", {
                    clientX: touch.clientX,
                    clientY: touch.clientY
                });
                canvas.dispatchEvent(me);
            }, false);

            canvas.addEventListener("touchend", function(e) {
                var me = new MouseEvent("mouseup", {});
                canvas.dispatchEvent(me);
            }, false);

            function getMousePos(canvasDom, mouseEvent) {
                var rect = canvasDom.getBoundingClientRect();
                return {
                    x: mouseEvent.clientX - rect.left,
                    y: mouseEvent.clientY - rect.top
                }
            }

            function getTouchPos(canvasDom, touchEvent) {
                var rect = canvasDom.getBoundingClientRect();
                return {
                    x: touchEvent.touches[0].clientX - rect.left,
                    y: touchEvent.touches[0].clientY - rect.top
                }
            }

            function renderCanvas() {
                if (drawing) {
                    ctx.moveTo(lastPos.x, lastPos.y);
                    ctx.lineTo(mousePos.x, mousePos.y);
                    ctx.stroke();
                    lastPos = mousePos;
                }
            }

            // Prevent scrolling when touching the canvas
            document.body.addEventListener("touchstart", function(e) {
                if (e.target == canvas) {
                    e.preventDefault();
                }
            }, false);
            document.body.addEventListener("touchend", function(e) {
                if (e.target == canvas) {
                    e.preventDefault();
                }
            }, false);
            document.body.addEventListener("touchmove", function(e) {
                if (e.target == canvas) {
                    e.preventDefault();
                }
            }, false);

            (function drawLoop() {
                requestAnimFrame(drawLoop);
                renderCanvas();
            })();

            function clearCanvas() {
                canvas.width = canvas.width;
            }

            // Set up the UI
            var sigText = document.getElementById("sig-dataUrl");
            var sigImage = document.getElementById("sig-image");
            var clearBtn = document.getElementById("sig-clearBtn");
            var submitBtn = document.getElementById("sig-submitBtn");
            clearBtn.addEventListener("click", function(e) {
                clearCanvas();
                sigText.value = "";
                sigImage.setAttribute("src", "");
            }, false);
            submitBtn.addEventListener("click", function(e) {
                var dataUrl = canvas.toDataURL();
                sigText.value = dataUrl;
                sigImage.setAttribute("src", dataUrl);
            }, false);

        })();
    </script>
    <script>
        function showModal() {
            var modal = document.getElementById("myModal");
            modal.classList.add("uk-open");
            modal.style.display = "block";
        }

        function submitForm() {
            var alasan = document.getElementById("alasan").value;
            var keterangan = document.getElementById("keterangan");
            keterangan.value = alasan + ' ' + keterangan.value;
            document.getElementById("form-batal-pesanan").submit();
        }
    </script>
    @endpush
</x-app-layout>
