	// generate new row
    // perform by manually add html codes in variable and piece it together
    var product = '<td><select id="product%ID%" class="receipt-product-list form-control" name="product%ID%" onchange="observe_change(\'%ID%\')"></select></td>';
    // make input quantity
    var quantity = '<td class="td_quantity"><input id="product%ID%_quantity" class="receipt-product-quantity form-control" name="product%ID%_quantity" onfocus="observe_change(\'%ID%\')" onchange="observe_change(\'%ID%\')" type="number" min="0" value="0" placeholder="Số lượng"></td>';
    // price of product
    var price  = '<td><p id="product%ID%_price" class="receipt-product-price form-control">Product Price</p></td>';
    // total price
    var total = '<td><p id="product%ID%_total" class="receipt-product-total  form-control">Total price</p></td>';
    // add button (guess it's not need now) lol :v
    var button = '<td><p id="add%ID%" class="btn btn-default btn-add form-control" tabindex="-1" style="opacity:0"><span class="glyphicon glyphicon-plus"></span></button></td>';
    // piece every thing together
    var row = '<tr id="receipt-row%ID%">' + product + quantity + price + total + button + '</tr>';
    // select option
    var html_option = "<option value=\'%VALUE%\'> %NAME% %UNITNAME%</option>";    
    // receipt first row
    var receipt_dashed_row = "<tr><td class='tri_dashed_line'>%OBJECT1%</td><td class='tri_dashed_line'>%OBJECT2%</td><td class='tri_dashed_line'>%OBJECT3%</td></tr>";
    // receipt row
    var receipt_row = "<tr><td>%OBJECT1%</td><td>%OBJECT2%</td><td>%OBJECT3%</td></tr>";
    // receipt information table
    // temp: "<table><tr><td><b>Địa Chỉ: </b></td><td>%ADDRESS%</td></tr><tr><td><b>Điện thoại: </b></td><td>%TEL%</td></tr><tr><td><b>Hóa đơn số: </b></td><td>%RECEIPTID%</td></tr><tr><td><b>Ngày: </b></td><td>%DATE%  %TIME%</td></tr><tr><td><b>Thu ngân: </b></td><td>%CASHIER%</td></tr></table>"
    var receipt_info_table = "<table><tr><td><b>Địa Chỉ: </b></td><td>%ADDRESS%</td></tr><tr><td><b>Điện thoại: </b></td><td>%TEL%</td></tr><tr><td><b>Ngày: </b></td><td>%DATE%  %TIME%</td></tr><tr><td><b>Thu ngân: </b></td><td>%CASHIER%</td></tr></table>";
    // Tam An address
    var tam_an_address = "Số 66, Phạm Hùng, Quy Nhơn, Bình Định.";
    // Tam An address
    var tam_an_tel = "01236037979";
    // thank you quote
    var receipt_thanks = "<br /><p><b> Cám ơn và hẹn gặp lại! </b></p>";

    var ALTER_PRODUCT_ROW=[
            '<tr id ="alter-product%PRODUCT_ID%">',
            '<td  id ="alter-product%PRODUCT_ID%-id" class="STT-product">%PRODUCT_ID%</td>',
            '<td><input id ="alter-product%PRODUCT_ID%-name" class="alter-product-name form-control product-list" sorttable_customkey ="%PRODUCT_NAME%" value = "%PRODUCT_NAME%" onchange="alter_product_observe(4,\'%PRODUCT_ID%\')"></td>',
            '<td><input id ="alter-product%PRODUCT_ID%-unit" class="alter-product-unit form-control product-list" sorttable_customkey ="%PRODUCT_UNIT_NAME%" value = "%PRODUCT_UNIT_NAME%" onchange="alter_product_observe(4,\'%PRODUCT_ID%\')"></td>',
            '<td><input id ="alter-product%PRODUCT_ID%-bought" type="number" class="alter-product-bought form-control" sorttable_customkey ="%PRODUCT_BOUGHT%" value = "%PRODUCT_BOUGHT%"  onchange="alter_product_observe(0,\'%PRODUCT_ID%\')"></td>',
            '<td><input id ="alter-product%PRODUCT_ID%-percentage" type="number" class="alter-product-percentage form-control" sorttable_customkey ="%PRODUCT_PERCENTAGE%" value = "%PRODUCT_PERCENTAGE%" onchange="alter_product_observe(1,\'%PRODUCT_ID%\')"></td>',
            '<td><input id ="alter-product%PRODUCT_ID%-sale" type="number" class="alter-product-sale form-control" sorttable_customkey ="%PRODUCT_SALE%" value = "%PRODUCT_SALE%" onchange="alter_product_observe(2,\'%PRODUCT_ID%\')"></td>',
            '<td style="padding-top: 15px;" ><input type="checkbox" name="foo" class = "alter-product-check-box" value="%PRODUCT_ID%"  tabindex="-1"><br/></td>',
            '</tr>'
        ];
    var ALTER_PRODUCT_ADD_NEW_PRODUCT_ROW=[
            '<tr id ="alter-product-no-id%PRODUCT_ID%">',
            '<td class="no-id-product">Mới</td>',
            '<td><input id ="alter-product-no-id%PRODUCT_ID%-name" class="alter-product-name form-control product-list" sorttable_customkey ="%PRODUCT_NAME%" value = "%PRODUCT_NAME%"></td>',
            '<td><input id ="alter-product-no-id%PRODUCT_ID%-unit" class="alter-product-unit form-control product-list" sorttable_customkey ="%PRODUCT_UNIT_NAME%" value = "%PRODUCT_UNIT_NAME%" onchange="alter_add_product_observe(4,\'%PRODUCT_ID%\')"></td>',
            '<td><input id ="alter-product-no-id%PRODUCT_ID%-bought" type="number" class="alter-product-bought form-control" sorttable_customkey ="%PRODUCT_BOUGHT%" value = "%PRODUCT_BOUGHT%"  onchange="alter_add_product_observe(0,\'%PRODUCT_ID%\')"></td>',
            '<td><input id ="alter-product-no-id%PRODUCT_ID%-percentage" type="number" class="alter-product-percentage form-control" sorttable_customkey ="%PRODUCT_PERCENTAGE%" value = "%PRODUCT_PERCENTAGE%" onchange="alter_add_product_observe(1,\'%PRODUCT_ID%\')"></td>',
            '<td><input id ="alter-product-no-id%PRODUCT_ID%-sale" type="number" class="alter-product-sale form-control" sorttable_customkey ="%PRODUCT_SALE%" value = "%PRODUCT_SALE%" onchange="alter_add_product_observe(2,\'%PRODUCT_ID%\')"></td>',
            '<td>%ACTION%</td>',
            '</tr>'
        ];
    var scaled_logo = "<img src='"+get_path('media','image/logo.jpg')+"' id='tri_img' />";