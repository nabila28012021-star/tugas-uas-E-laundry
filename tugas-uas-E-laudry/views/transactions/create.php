<form action="<?= BASE_URL ?>/transaction/store" method="post" id="transactionForm">
    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
    
    <div class="row">
        <!-- Customer Info -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">
                        <i class="fas fa-user mr-2"></i>
                        Data Pelanggan
                    </h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Pilih Pelanggan</label>
                        <select class="form-control select2" id="customer_id" name="customer_id">
                            <option value="0">-- Pelanggan Baru --</option>
                            <?php foreach ($customers as $customer): ?>
                            <option value="<?= $customer['id'] ?>" data-phone="<?= htmlspecialchars($customer['phone']) ?>" data-address="<?= htmlspecialchars($customer['address'] ?? '') ?>">
                                <?= htmlspecialchars($customer['name']) ?> - <?= $customer['phone'] ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div id="newCustomerFields">
                        <div class="form-group">
                            <label>Nama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Nama pelanggan">
                        </div>
                        
                        <div class="form-group">
                            <label>Telepon <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" id="customer_phone" name="customer_phone" placeholder="08xxxxxxxxxx">
                        </div>
                        
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea class="form-control" id="customer_address" name="customer_address" rows="2" placeholder="Alamat"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Promo Code -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-tags mr-2"></i>
                        Kode Promo
                    </h3>
                </div>
                <div class="card-body">
                    <div class="input-group">
                        <input type="text" class="form-control text-uppercase" id="promo_code" name="promo_code" placeholder="Masukkan kode promo" style="text-transform: uppercase;">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-secondary" id="checkPromo">
                                <i class="fas fa-check"></i>
                            </button>
                        </div>
                    </div>
                    <div id="promoResult" class="mt-2"></div>
                </div>
            </div>
            
            <!-- Notes -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-sticky-note mr-2"></i>
                        Catatan
                    </h3>
                </div>
                <div class="card-body">
                    <textarea class="form-control" name="notes" rows="3" placeholder="Catatan khusus..."></textarea>
                </div>
            </div>
        </div>
        
        <!-- Items -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h3 class="card-title">
                        <i class="fas fa-box mr-2"></i>
                        Item Laundry
                    </h3>
                </div>
                <div class="card-body">
                    <div id="itemsContainer">
                        <div class="item-row mb-3 p-3 bg-light rounded">
                            <div class="row">
                                <div class="col-md-5">
                                    <label>Paket Layanan <span class="text-danger">*</span></label>
                                    <select class="form-control package-select" name="package_id[]" required>
                                        <option value="">-- Pilih Paket --</option>
                                        <?php foreach ($packages as $package): ?>
                                        <option value="<?= $package['id'] ?>" data-price="<?= $package['price'] ?>" data-type="<?= $package['type'] ?>">
                                            <?= htmlspecialchars($package['name']) ?> - <?= Package::formatPrice($package['price']) ?>/<?= $package['type'] ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Jumlah <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control quantity-input" name="quantity[]" min="0.1" step="0.1" value="1" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text unit-label">kg</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Subtotal</label>
                                    <input type="text" class="form-control item-subtotal" readonly value="Rp 0">
                                </div>
                                <div class="col-md-1">
                                    <label>&nbsp;</label>
                                    <button type="button" class="btn btn-danger btn-block remove-item" disabled>
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <button type="button" class="btn btn-outline-primary btn-block" id="addItem">
                        <i class="fas fa-plus mr-2"></i> Tambah Item
                    </button>
                </div>
                
                <!-- Summary -->
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6 offset-md-6">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <td>Subtotal:</td>
                                    <td class="text-right"><strong id="subtotalDisplay">Rp 0</strong></td>
                                </tr>
                                <tr id="discountRow" style="display: none;">
                                    <td>Diskon:</td>
                                    <td class="text-right text-danger"><strong id="discountDisplay">- Rp 0</strong></td>
                                </tr>
                                <tr class="border-top">
                                    <td><h4 class="mb-0">Total:</h4></td>
                                    <td class="text-right"><h4 class="mb-0 text-primary" id="totalDisplay">Rp 0</h4></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="text-right">
                        <a href="<?= BASE_URL ?>/transaction" class="btn btn-secondary mr-2">
                            <i class="fas fa-arrow-left mr-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save mr-2"></i> Simpan Transaksi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
$(document).ready(function() {
    let discount = 0;
    let promoValid = false;
    
    // Customer selection
    $('#customer_id').on('change', function() {
        var customerId = $(this).val();
        if (customerId == '0') {
            $('#newCustomerFields').show();
            $('#customer_name, #customer_phone').attr('required', true);
        } else {
            $('#newCustomerFields').hide();
            $('#customer_name, #customer_phone').removeAttr('required');
        }
    });
    
    // Package selection
    $(document).on('change', '.package-select', function() {
        var row = $(this).closest('.item-row');
        var option = $(this).find(':selected');
        var type = option.data('type');
        row.find('.unit-label').text(type === 'satuan' ? 'pcs' : 'kg');
        calculateTotals();
    });
    
    // Quantity change
    $(document).on('input', '.quantity-input', function() {
        calculateTotals();
    });
    
    // Add item
    $('#addItem').on('click', function() {
        var newRow = $('#itemsContainer .item-row:first').clone();
        newRow.find('select').val('');
        newRow.find('.quantity-input').val('1');
        newRow.find('.item-subtotal').val('Rp 0');
        newRow.find('.remove-item').prop('disabled', false);
        $('#itemsContainer').append(newRow);
        updateRemoveButtons();
    });
    
    // Remove item
    $(document).on('click', '.remove-item', function() {
        $(this).closest('.item-row').remove();
        updateRemoveButtons();
        calculateTotals();
    });
    
    function updateRemoveButtons() {
        var items = $('#itemsContainer .item-row');
        items.find('.remove-item').prop('disabled', items.length === 1);
    }
    
    // Check promo
    $('#checkPromo').on('click', function() {
        var code = $('#promo_code').val().trim();
        if (!code) {
            $('#promoResult').html('<small class="text-danger">Masukkan kode promo</small>');
            discount = 0;
            promoValid = false;
            calculateTotals();
            return;
        }
        
        var subtotal = calculateSubtotal();
        
        $.get('<?= BASE_URL ?>/promo/validate', { code: code, subtotal: subtotal }, function(response) {
            if (response.success) {
                $('#promoResult').html('<small class="text-success"><i class="fas fa-check-circle"></i> ' + response.promo.name + ' - ' + response.discount_formatted + '</small>');
                discount = response.discount;
                promoValid = true;
            } else {
                $('#promoResult').html('<small class="text-danger"><i class="fas fa-times-circle"></i> ' + response.message + '</small>');
                discount = 0;
                promoValid = false;
            }
            calculateTotals();
        }).fail(function() {
            $('#promoResult').html('<small class="text-danger">Gagal memeriksa promo</small>');
        });
    });
    
    function calculateSubtotal() {
        var subtotal = 0;
        $('#itemsContainer .item-row').each(function() {
            var price = parseFloat($(this).find('.package-select option:selected').data('price')) || 0;
            var qty = parseFloat($(this).find('.quantity-input').val()) || 0;
            subtotal += price * qty;
        });
        return subtotal;
    }
    
    function calculateTotals() {
        var subtotal = 0;
        
        $('#itemsContainer .item-row').each(function() {
            var price = parseFloat($(this).find('.package-select option:selected').data('price')) || 0;
            var qty = parseFloat($(this).find('.quantity-input').val()) || 0;
            var itemSubtotal = price * qty;
            subtotal += itemSubtotal;
            $(this).find('.item-subtotal').val(formatRupiah(itemSubtotal));
        });
        
        $('#subtotalDisplay').text(formatRupiah(subtotal));
        
        if (discount > 0) {
            $('#discountRow').show();
            $('#discountDisplay').text('- ' + formatRupiah(discount));
        } else {
            $('#discountRow').hide();
        }
        
        var total = Math.max(0, subtotal - discount);
        $('#totalDisplay').text(formatRupiah(total));
    }
    
    function formatRupiah(angka) {
        return 'Rp ' + angka.toLocaleString('id-ID');
    }
    
    // Initial calculation
    calculateTotals();
});
</script>
