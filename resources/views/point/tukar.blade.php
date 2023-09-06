<x-app-layout>
    <section id="navbarSecondary" class="uk-flex uk-flex-middle uk-flex-left">
        <div class="uk-width-1-1">
            <div class="uk-container">
                <h2 class="rz-text-pagetitle">Tukar Point</h2>
            </div>

        </div>

    </section>
    <section class="uk-margin-medium">
        <div class="uk-container">
            <div uk-grid>
                <div class="uk-width-1-3@s">
                    <div class="rz-panel">
                        <div>Point Anda</div>
                        <div class="uk-text-large">{{ $total_point }}</div>

                    </div>
                </div>
                <div class="uk-width-2-3@s">
                    <div class="rz-panel">
                        <div class="uk-margin-large">
                            <h5>Pilih Merchant</h5>
                            <table class="uk-table uk-table-small uk-table-striped">
                                <thead>
                                    <tr>
                                        <th class="uk-table-expand">Penukaran Point</th>
                                        <th class="uk-table-shrink uk-text-nowrap">Point Ditukar</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    @foreach ($merchant as $m)
                                        <tr>
                                            <td>{{ $m->voucher_name }}</td>
                                            <td class="uk-text-right">{{ $m->amount }} pt</td>
                                            {{-- <td class="uk-text-right"><a class="add_cart btn-cart" data-xyz="1"
                                                    data-customer_id="{{ auth()->user()->id }}"
                                                    data-merchant_id="{{ $m->merchant_id }}"
                                                    data-point_cust="{{ $total_point }}"
                                                    data-point_merchant="{{ $m->amount }}"><span id="btn-cart"
                                                        uk-icon="cart"></span></a>
                                            </td> --}}
                                            <td class="uk-text-right">
                                                <a onclick="addToCart({{ $m->merchant_id }})"><span id="btn-cart" uk-icon="cart"></span></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <table class="rz-table-vertical">
                                <tr>
                                    <th>Total Merchant ditukar:</th>
                                    <td><span id="mertukar"></span></td>
                                </tr>
                                <tr>
                                    <th>Total Point ditukar:</th>
                                    <td>
                                        <span id="sisapoint"></span>
                                    </td>
                                </tr>
                            </table>



                        </div>
                        <div>
                            <a href="" class="uk-button uk-button-default uk-border-rounded">Lihat Keranjang</a>
                            <a href="#modalPointCheckout" class="uk-button uk-button-primary uk-border-rounded" uk-toggle>Checkout</a>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>

    <div id="modalPointCheckout" class="uk-modal-container" uk-modal>
        <div class="uk-modal-dialog uk-modal-body">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <h5>Check Out point Redeem</h5>
            <div uk-grid>
                <div class="uk-width-2-3@s">
                    <table class="uk-table uk-table-small uk-table-striped">
                        <thead>
                            <tr>
                                <th class="uk-table-expand">merchant Ditukar</th>
                                <th class="uk-table-shrink uk-text-nowrap">Point Ditukar</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td> E-Voucher 100rb MAP </td>
                                <td class="uk-text-right">250 pt</td>
                            </tr>
                            <tr>
                                <td> E-Voucher 100rb SOGO </td>
                                <td class="uk-text-right">300 pt</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="uk-width-1-3@s">
                    <table class="rz-table-vertical uk-margin-medium-top">
                        <tr>
                            <th>Total Merchant ditukar:</th>
                            <td>2</td>
                        </tr>
                        <tr>
                            <th>Total Point ditukar:</th>
                            <td> pt</td>
                        </tr>
                        <tr>
                            <th>Sisa Point:</th>
                            <td>1,750 pt</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="uk-margin-large-top">
                <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
                <a href="{{ route('tukar.index') }}" class="uk-button uk-button-primary uk-border-rounded">Konfirmasi
                    Penukaran</a>
            </div>
        </div>
    </div>
    @push('script')
        <script type="text/javascript">
            function addToCart (merchId){
                // countCart();
                alert(merchId)
            }
            
            function countCart(){
                $.ajax({
                    type:"GET",
                    url:'/countcartpoint',
                    dataType:'JSON',
                    success:function(response){
                        console.log(response)
                    }
                })
            }

            // $(document).ready(function() {
            //     $.ajaxSetup({
            //         'headers': {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         }
            //     })
            //     $('.add_cart').click(function() {
            //         var xyz = $(this).data("xyz");
            //         var customer_id = $(this).data("customer_id");
            //         var merchant_id = $(this).data("merchant_id");
            //         var point_cust = $(this).data("point_cust");
            //         var point_merchant = $(this).data("point_merchant");
            //         let token = $("meta[name='csrf-token']").attr("content");
            //         let cartBtn = document.querySelectorAll(".btn-cart");

            //         let uid = [];
            //         for (let i = 0; i < cartBtn.length; i++) {
            //             cartBtn[i].addEventListener('click', (e) => {
            //                 e.preventDefault();
            //                 console.log('add to cart')
            //             })
            //         }

            //         if (point_cust < point_merchant) {
            //             alert('Point tidak cukup');
            //         } else {
            //             $.ajax({
            //                 url: '/addtocart',
            //                 type: 'POST',
            //                 data: {
            //                     // "total_amb": total,
            //                     "customer_id": customer_id,
            //                     "merchant_id": merchant_id,
            //                     "point_cust": point_cust,
            //                     "point_merchant": point_merchant,
            //                     "_token": token
            //                 },
            //                 cache: false,
            //                 success: function(data) {
            //                     // alert(point_merchant)
            //                     // document.getElementById("sisapoint").innerHTML = total + " pt";
            //                     // document.getElementById("mertukar").innerHTML = total;
            //                 }
            //             });
            //         }
            //     })
            // })
        </script>
    @endpush
</x-app-layout>
