<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Form</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">
    <form action="{{ route('invoice.generate-pdf') }}" method="POST" enctype="multipart/form-data"
        class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-8">
        @csrf
        <div class="flex justify-between mb-8">
            <div>
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <div id="logo-preview"
                            class="w-24 h-24 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center overflow-hidden">
                            <img id="preview-image" class="hidden w-full h-full object-contain" src=""
                                alt="Company Logo">
                            <div id="logo-placeholder" class="text-gray-400 text-center">
                                <svg class="w-8 h-8 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                
                            </div>
                        </div>
                        <input type="file" id="logo-upload" name="company_logo" class="hidden" accept="image/*">
                        <button type="button" id="upload-trigger"
                            class="mt-2 text-sm text-blue-500 hover:text-blue-600">Change Logo</button>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">INVOICE</h1>
                        <input type="text" name="company_name"
                            class="mt-2 border rounded p-2 @error('company_name') border-red-500 @enderror"
                            placeholder="Your Company Name" value="{{ old('company_name') }}">
                        @error('company_name')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div>
                <p class="text-gray-600">Invoice #: <input type="text" name="invoice_number"
                        class="border rounded p-1 w-24 @error('invoice_number') border-red-500 @enderror"
                        id="invoice-number" value="{{ old('invoice_number') }}"></p>
                @error('invoice_number')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
                <p class="text-gray-600 mt-2">Date: <input type="date" name="invoice_date"
                        class="border rounded p-1 @error('invoice_date') border-red-500 @enderror" id="invoice-date"
                        value="{{ old('invoice_date') }}"></p>
                @error('invoice_date')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
                <p class="text-gray-600 mt-2">Due Date: <input type="date" name="due_date"
                        class="border rounded p-1 @error('due_date') border-red-500 @enderror" id="due-date"
                        value="{{ old('due_date') }}"></p>
                @error('due_date')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
                <p class="text-gray-600 mt-2">PO #: <input type="text" name="po_number"
                        class="border rounded p-1 w-24 @error('po_number') border-red-500 @enderror" id="po-number"
                        value="{{ old('po_number') }}"></p>
                @error('po_number')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-8 mb-8">
            <div>
                <h2 class="text-gray-700 font-semibold mb-2">Bill To:</h2>
                <input type="text" name="bill_to_name"
                    class="border rounded p-2 w-full mb-2 @error('bill_to_name') border-red-500 @enderror"
                    placeholder="Client Name" value="{{ old('bill_to_name') }}">
                @error('bill_to_name')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
                <textarea name="bill_to_address"
                    class="border rounded p-2 w-full @error('bill_to_address') border-red-500 @enderror" rows="3"
                    placeholder="Client Address">{{ old('bill_to_address') }}</textarea>
                @error('bill_to_address')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <h2 class="text-gray-700 font-semibold mb-2">Ship To:</h2>
                <input type="text" name="ship_to_name"
                    class="border rounded p-2 w-full mb-2 @error('ship_to_name') border-red-500 @enderror"
                    placeholder="Shipping Name" value="{{ old('ship_to_name') }}">
                @error('ship_to_name')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
                <textarea name="ship_to_address"
                    class="border rounded p-2 w-full @error('ship_to_address') border-red-500 @enderror" rows="3"
                    placeholder="Shipping Address">{{ old('ship_to_address') }}</textarea>
                @error('ship_to_address')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <table class="w-full mb-8">
            <thead>
                <tr class="bg-gray-50">
                    <th class="p-2 text-left">Item</th>
                    <th class="p-2 text-left">Description</th>
                    <th class="p-2 text-right">Quantity</th>
                    <th class="p-2 text-right">Rate</th>
                    <th class="p-2 text-right">Amount</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="item-rows">
                <tr class="item-row">
                    <td><input type="text" name="items[0][name]"
                            class="border rounded p-2 w-full item-name @error('items.0.name') border-red-500 @enderror">
                    </td>
                    @error('items.0.name')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                    <td colspan=""><input type="text" name="items[0][description]"
                            class="border rounded p-2 w-full item-description @error('items.0.description') border-red-500 @enderror">
                    </td>
                    @error('items.0.description')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                    <td><input type="number" name="items[0][quantity]"
                            class="border rounded p-2 w-full text-right item-quantity @error('items.0.quantity') border-red-500 @enderror"
                            value="1" onkeypress="return event.charCode >= 48 && event.charCode <= 57"></td>
                    @error('items.0.quantity')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                    <td><input type="number" name="items[0][rate]"
                            class="border rounded p-2 w-full text-right item-rate @error('items.0.rate') border-red-500 @enderror"
                            value="0.00" onkeypress="return isNumber(event)"></td>
                    @error('items.0.rate')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                    <td><input type="number" name="items[0][amount]"
                            class="border rounded p-2 w-full text-right item-amount" readonly></td>
                    <td><button type="button" class="text-red-500 delete-row">×</button></td>
                </tr>
            </tbody>
        </table>

        <button type="button" id="add-item" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-8">Add
            Item</button>

        <div class="flex justify-end">
            <div class="w-64">
                <div class="flex justify-between mb-2">
                    <span>Subtotal:</span>
                    <span id="subtotal">$0.00</span>
                    <input type="hidden" name="subtotal" id="subtotal-input" value="0">
                </div>
                <div class="flex justify-between mb-2">
                    <span>Discount:</span>
                    <div class="flex items-center">
                        <input type="number" name="discount_rate" id="discount-rate" onkeypress="return isNumber(event)"
                            class="border rounded p-1 w-20 text-right mr-1 @error('discount_rate') border-red-500 @enderror"
                            value="0">%
                    </div>
                    @error('discount_rate')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div class="flex justify-between mb-2">
                    <span>Discount Amount:</span>
                    <span id="discount-total">$0.00</span>
                    <input type="hidden" name="discount_amount" id="discount-amount" value="0" >
                </div>
                <div class="flex justify-between mb-2">
                    <span>Tax Rate:</span>
                    <div class="flex items-center">
                        <input type="number" name="tax_rate" id="tax-rate" onkeypress="return isNumber(event)"
                            class="border rounded p-1 w-20 text-right @error('tax_rate') border-red-500 @enderror"
                            value="0">%
                    </div>
                    @error('tax_rate')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div class="flex justify-between mb-2">
                    <span>Tax Amount:</span>
                    <span id="tax-amount">$0.00</span>
                    <input type="hidden" name="tax_amount" id="tax-amount-input" value="0">
                </div>
                <div class="flex justify-between font-bold">
                    <span>Total:</span>
                    <span id="total">$0.00</span>
                    <input type="hidden" name="total" id="total-input" value="0">
                </div>
            </div>
        </div>

        <div class="mt-8">
            <h2 class="text-gray-700 font-semibold mb-2">Notes:</h2>
            <textarea name="notes" class="border rounded p-2 w-full @error('notes') border-red-500 @enderror" rows="3"
                placeholder="Additional notes to the client">{{ old('notes') }}</textarea>
            @error('notes')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div class="mt-8 flex justify-end">
            <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">Generate
                PDF</button>
        </div>
    </form>

    <script>
        function isNumber(event) {
            let charCode = event.charCode;
            let inputValue = event.target.value;

            // Allow numbers (0-9)
            if (charCode >= 48 && charCode <= 57) {
                return true;
            }

            // Allow only one dot (.)
            if (charCode === 46 && !inputValue.includes(".")) {
                return true;
            }

            return false; // Block other characters
        }


        $(document).ready(function () {
            $('#upload-trigger').click(function () {
                $('#logo-upload').click();
            });

            $('#logo-upload').change(function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        $('#preview-image').attr('src', e.target.result).removeClass('hidden');
                        $('#logo-placeholder').addClass('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });

            $('#add-item').click(function () {
                const newRow = $('.item-row:first').clone();
                const rowCount = $('.item-row').length;
                newRow.find('input').each(function () {
                    const name = $(this).attr('name');
                    if (name) {
                        $(this).attr('name', name.replace('[0]', `[${rowCount}]`));
                    }
                });
                newRow.find('input').val('');
                newRow.find('.item-quantity').val(1);
                newRow.find('.item-rate').val('0.00');
                $('#item-rows').append(newRow);
                calculateTotals();
            });

            $(document).on('click', '.delete-row', function () {
                if ($('.item-row').length > 1) {
                    $(this).closest('tr').remove();
                    calculateTotals();
                }
            });

            $(document).on('input', '.item-quantity, .item-rate', function () {
                const row = $(this).closest('tr');
                const quantity = parseFloat(row.find('.item-quantity').val()) || 0;
                const rate = parseFloat(row.find('.item-rate').val()) || 0;
                const amount = quantity * rate;
                row.find('.item-amount').val(amount.toFixed(2));
                calculateTotals();
            });

            function calculateTotals() {
                let subtotal = 0;
                $('.item-amount').each(function () {
                    subtotal += parseFloat($(this).val()) || 0;
                });

                const discountRate = parseFloat($('#discount-rate').val()) || 0;
                const discountAmount = parseFloat($('#discount-amount').val()) || 0;
                let finalDiscount = 0;

                if (discountRate > 0) {
                    finalDiscount = subtotal * (discountRate / 100);
                } else if (discountAmount > 0) {
                    finalDiscount = discountAmount;
                }

                const afterDiscount = subtotal - finalDiscount;
                const taxRate = parseFloat($('#tax-rate').val()) || 0;
                const taxAmount = afterDiscount * (taxRate / 100);
                const total = afterDiscount + taxAmount;

                $('#subtotal').text('$' + subtotal.toFixed(2));
                $('#subtotal-input').val(subtotal.toFixed(2));
                $('#discount-total').text('$' + finalDiscount.toFixed(2));
                $('#discount-amount').val(finalDiscount.toFixed(2));
                $('#tax-amount').text('$' + taxAmount.toFixed(2));
                $('#tax-amount-input').val(taxAmount.toFixed(2));
                $('#total').text('$' + total.toFixed(2));
                $('#total-input').val(total.toFixed(2));
            }

            $('#tax-rate, #discount-rate, #discount-amount').on('input', function () {
                if ($(this).attr('id') === 'discount-rate') {
                    $('#discount-amount').val('0.00');
                } else if ($(this).attr('id') === 'discount-amount') {
                    $('#discount-rate').val('0');
                }
                calculateTotals();
            });
        });
    </script>
</body>

</html>