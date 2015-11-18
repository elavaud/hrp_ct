/* 
 * JS file containing all the functions used during the submission or the edition of clinical trials.
 * Step 3: INVESTIGATIONAL DRUG PRODUCT INFORMATION
 */

function addDrugInfo(){
    var drugHtml = '<div class="drugSupp" id="articleDrugs-X">' + $('#articleDrugs-0').html() + '</div>';
    if ($(".drugSupp").length){
        var selectName = $('div.drugSupp:last').attr('id');
        var selectNameStartRemoved = selectName.replace('articleDrugs-', '');
        var fieldId = parseInt(selectNameStartRemoved) + 1;
    } else {    
        var fieldId = 1;
    }     
    drugHtml = drugHtml.replace('articleDrugs-X', 'articleDrugs-'+fieldId);
    for (i = 0; i < 50; i++) { 
        drugHtml = drugHtml.replace('articleDrugs-0', 'articleDrugs-'+fieldId);
    }
    for (i = 0; i < 50; i++) { 
        drugHtml = drugHtml.replace('articleDrugs[0', 'articleDrugs['+fieldId);
    }
    if ($(".drugSupp").length){
        $('div.drugSupp:last').after(drugHtml);
    } else {
        $('#articleDrugs-0').after(drugHtml);
    }
    $('div.drugSupp:last').find('.hiddenInputs').remove('');
    $('div.drugSupp:last').find('tr.showHideHelpField').remove('');
    $('div.drugSupp:last').find('a.showHideHelpButton').remove('');    
    $('#articleDrugs-'+fieldId+'-type').removeAttr('disabled');   
    $('#articleDrugs-'+fieldId+'-type').append('<option value=""></option>');
    $('#articleDrugs-'+fieldId+'-type').val('');            
    $('#articleDrugs-'+fieldId).find('.removeDrug').show();
    $('#articleDrugs-'+fieldId).find('.removeDrug').click(function(){$(this).closest('div').remove();});   
    $('#articleDrugs-'+fieldId+'-title').html(fieldId+1);
    $('#articleDrugs-'+fieldId+'-name').val('');
    $('#articleDrugs-'+fieldId+'-brandName').val('');
    $('#articleDrugs-'+fieldId+'-administration').val('');
    $('#articleDrugs-'+fieldId+'-administration').change(function(e) {var id = e.target.id;showOrHideOherAdministrationField(id);});
    showOrHideOherAdministrationFields();
    $('#articleDrugs-'+fieldId+'-form').val('');
    $('#articleDrugs-'+fieldId+'-form').change(function(e) {var id = e.target.id;showOrHideOherFormField(id);});
    showOrHideOherFormFields();
    $('#articleDrugs-'+fieldId+'-strength').val('');
    $('#articleDrugs-'+fieldId+'-storage').val('');
    $('#articleDrugs-'+fieldId+'-pharmaClass').val('');
    $('#articleDrugs-'+fieldId).find("input:checkbox").removeAttr("checked");
    $('#articleDrugs-'+fieldId).find("input:checkbox").each(function () {$(this).click(function(e) {var name = e.target.name;showOrHideCountriesConditionsField(name);});});
    showOrHideCountriesConditionsFields();
    $('#articleDrugs-'+fieldId).find('.addAnotherCountryClick').click(function(e) {var id = e.target.id;addCountry(id);}); 
    $('#articleDrugs-'+fieldId).find('.countrySupp-'+fieldId).remove(); 
    $('#articleDrugs-'+fieldId).find('input:radio[name="articleDrugs['+fieldId+'][cpr]"]').each(function () {this.checked = false;});
    $('#articleDrugs-'+fieldId).find('input:radio[name="articleDrugs['+fieldId+'][cpr]"]').each(function () {$(this).click(function (e){var name = e.target.name;showOrHideDrugRegistrationNumber(name);});});
    $('#articleDrugs-'+fieldId+'-drugRegistrationNumber').val('');
    showOrHideDrugRegistrationNumbers();
    $('#articleDrugs-'+fieldId+'-importedQuantity').val('');
    $('#articleDrugs-'+fieldId).find('.addAnotherManufacturerClick').click(function(e) {var id = e.target.id;addManufacturer(id);}); 
    $('#articleDrugs-'+fieldId).find('.manufacturerSupp-'+fieldId).remove();     
}

function showOrHideOherAdministrationField(id){
    var idStartRemoved = id.replace('articleDrugs-', '');
    var idStartAndEndRemoved = idStartRemoved.replace('-administration', '');
    var fieldId = parseInt(idStartAndEndRemoved);
    var value = $("#"+id).val();
    if (value === 'OTHER') {
        $('#articleDrugs-'+fieldId+'-otherAdministrationField').show();
        if($('#articleDrugs-'+fieldId+'-otherAdministration').val() === "NA") {
            $('#articleDrugs-'+fieldId+'-otherAdministration').val("");
        }
    } else {
        $('#articleDrugs-'+fieldId+'-otherAdministrationField').hide();
        $('#articleDrugs-'+fieldId+'-otherAdministration').val("NA");
    }
}

function showOrHideOherAdministrationFields(){
    $("select[id*='-administration']").each(
        function() {
           showOrHideOherAdministrationField($(this).attr("id"));
        }
    );
}

function showOrHideOherFormField(id){
    var idStartRemoved = id.replace('articleDrugs-', '');
    var idStartAndEndRemoved = idStartRemoved.replace('-form', '');
    var fieldId = parseInt(idStartAndEndRemoved);
    var value = $("#"+id).val();
    if (value === 'OTHER') {
        $('#articleDrugs-'+fieldId+'-otherFormField').show();
        if($('#articleDrugs-'+fieldId+'-otherForm').val() === "NA") {
            $('#articleDrugs-'+fieldId+'-otherForm').val("");
        }
    } else {
        $('#articleDrugs-'+fieldId+'-otherFormField').hide();
        $('#articleDrugs-'+fieldId+'-otherForm').val("NA");
    }
}

function showOrHideOherFormFields(){
    $("select[id*='-form']").each(
        function() {
           showOrHideOherFormField($(this).attr("id"));
        }
    );
}

function showOrHideCountriesConditionsField(name){
    var nameStartRemoved = name.replace('articleDrugs[', '');
    var nameStartAndEndRemoved = nameStartRemoved.replace('][studyClasses][]', '');
    var fieldId = parseInt(nameStartAndEndRemoved);
    var show = false;    
    $('input[type=checkbox]').each(
        function () {
            var cbName = $(this).attr('name');
            var cbNameStartRemoved = cbName.replace('articleDrugs[', '');
            var cbNameStartAndEndRemoved = cbNameStartRemoved.replace('][studyClasses][]', '');
            var cbFieldId = parseInt(cbNameStartAndEndRemoved);
            if (cbFieldId === fieldId) {
                if ($(this).val() === ARTICLE_DRUG_INFO_CLASS_III || $(this).val() == ARTICLE_DRUG_INFO_CLASS_IV) {
                    if ($(this).is(':checked')) {
                        show = true;
                    }
                }
            }
        }
    );
    if (show) {
        $('#articleDrugs-'+fieldId+'-classIIIOrIV').show();
        if ($('#articleDrugs-'+fieldId+'-country-0').find('option[value="NA"]').length) {
            $('#articleDrugs-'+fieldId+'-country-0').find('option[value="NA"]').remove();
        }
        if ($('#articleDrugs-'+fieldId+'-classIIIOrIV').find(':radio[value=NA]').length) {
            $('#articleDrugs-'+fieldId+'-classIIIOrIV').find(':radio[value=NA]').remove();
        }
    } else {
        $('#articleDrugs-'+fieldId+'-classIIIOrIV').hide();   
        if (!$('#articleDrugs-'+fieldId+'-country-0').find('option[value="NA"]').length) {
            $('#articleDrugs-'+fieldId+'-country-0').append('<option value="NA"></option>');
        }
        $('#articleDrugs-'+fieldId+'-country-0').val('NA')
        $('#articleDrugs-'+fieldId+'-classIIIOrIV').find('.countrySupp-'+fieldId).remove();
        if (!$('#articleDrugs-'+fieldId+'-classIIIOrIV').find(':radio[value=NA]').length) {
            $('#articleDrugs-'+fieldId+'-classIIIOrIV').append('<input type="radio" style="display:none;" name="articleDrugs['+fieldId+'][conditionsOfUse]" value="NA">');
        }
        $('#articleDrugs-'+fieldId+'-classIIIOrIV').find(':radio[value=NA]').attr('checked', 'checked');        
    }
}

function showOrHideCountriesConditionsFields(){
    $("input:checkbox").each(
        function () {
            showOrHideCountriesConditionsField($(this).attr("name"));
        }
    );
}

function addCountry(id) {
    var idStartRemoved = id.replace('articleDrugs-', '');
    var idStartAndEndRemoved = idStartRemoved.replace('-addCountry', '');
    var fieldId = parseInt(idStartAndEndRemoved);
    
    var countryHtml = '<tr class="countrySupp-'+fieldId+'" id="articleDrugs-"'+fieldId+'-countryTr-X>' + $('#articleDrugs-'+fieldId+'-countryTr-0').html() + '</tr>';
    if ($("tr.countrySupp-"+fieldId).length){
        var selectName = $('tr.countrySupp-'+fieldId+':last').attr('id');
        var selectNameStartRemoved = selectName.replace('articleDrugs-'+fieldId+'-countryTr-', '');
        var subFieldId = parseInt(selectNameStartRemoved) + 1;
    } else {    
        var subFieldId = 1;
    }     
    countryHtml = countryHtml.replace('articleDrugs-'+fieldId+'-countryTr-X', 'articleDrugs-'+fieldId+'-countryTr-'+subFieldId);
    for (i = 0; i < 10; i++) { 
        countryHtml = countryHtml.replace('articleDrugs-'+fieldId+'-country-0', 'articleDrugs-'+fieldId+'-country-'+subFieldId);
    }
    for (i = 0; i < 10; i++) { 
        countryHtml = countryHtml.replace('articleDrugs['+fieldId+'][country][0', 'articleDrugs['+fieldId+'][country]['+subFieldId);
    }
    if ($("tr.countrySupp-"+fieldId).length){
        $('tr.countrySupp-'+fieldId+':last').after(countryHtml);
    } else {
        $('#articleDrugs-'+fieldId+'-countryTr-0').after(countryHtml);
    }
    $('tr.countrySupp-'+fieldId+':last').find('td.countryTitle').hide();    
    $('tr.countrySupp-'+fieldId+':last').find('td.noCountryTitle').show();   
    $('#articleDrugs-'+fieldId+'-country-'+subFieldId).val('');
    $('tr.countrySupp-'+fieldId+':last').find('a.removeCountry').show();
    $('tr.countrySupp-'+fieldId+':last').find('a.removeCountry').click(function(){$(this).closest('tr').remove();});   
}

function showOrHideDrugRegistrationNumber(name){
    var nameStartRemoved = name.replace('articleDrugs[', '');
    var nameStartAndEndRemoved = nameStartRemoved.replace('][cpr]', '');
    var fieldId = parseInt(nameStartAndEndRemoved);
    var show = false;
    $('input:radio[name="'+name+'"]').each(
        function () {
            if ($(this).val() == ARTICLE_DRUG_INFO_YES) {
                if ($(this).is(':checked')) {
                    show = true;                    
                }
            }
        }
    );
    if (show) {
        $('#articleDrugs-'+fieldId+'-drugRegistrationNumberField').show();
        if ($('#articleDrugs-'+fieldId+'-drugRegistrationNumber').val() == 'NA') {
            $('#articleDrugs-'+fieldId+'-drugRegistrationNumber').val('');
        }
    } else {
        $('#articleDrugs-'+fieldId+'-drugRegistrationNumberField').hide();        
        $('#articleDrugs-'+fieldId+'-drugRegistrationNumber').val('NA');
    }
}

function showOrHideDrugRegistrationNumbers(){
    $('input:radio[name*="[cpr]"]').each(
        function () {
            showOrHideDrugRegistrationNumber($(this).attr("name"));
        }
    );
}

function addManufacturer(id) {
    var idStartRemoved = id.replace('articleDrugs-', '');
    var idStartAndEndRemoved = idStartRemoved.replace('-addManufacturer', '');
    var fieldId = parseInt(idStartAndEndRemoved);
    
    var manufacturerHtml = '<table width="100%" class="manufacturerSupp-'+fieldId+'" id="articleDrugs-"'+fieldId+'-manufacturer-X>' + $('#articleDrugs-'+fieldId+'-manufacturer-0').html() + '</table>';
    if ($("table.manufacturerSupp-"+fieldId).length){
        var selectName = $('table.manufacturerSupp-'+fieldId+':last').attr('id');
        var selectNameStartRemoved = selectName.replace('articleDrugs-'+fieldId+'-manufacturer-', '');
        var subFieldId = parseInt(selectNameStartRemoved) + 1;
    } else {    
        var subFieldId = 1;
    }     
    manufacturerHtml = manufacturerHtml.replace('articleDrugs-'+fieldId+'-manufacturer-X', 'articleDrugs-'+fieldId+'-manufacturer-'+subFieldId);
    for (i = 0; i < 10; i++) { 
        manufacturerHtml = manufacturerHtml.replace('articleDrugs-'+fieldId+'-manufacturer-0', 'articleDrugs-'+fieldId+'-manufacturer-'+subFieldId);
    }
    for (i = 0; i < 10; i++) { 
        manufacturerHtml = manufacturerHtml.replace('articleDrugs['+fieldId+'][manufacturer][0', 'articleDrugs['+fieldId+'][manufacturer]['+subFieldId);
    }
    if ($("table.manufacturerSupp-"+fieldId).length){
        $('table.manufacturerSupp-'+fieldId+':last').after(manufacturerHtml);
    } else {
        $('#articleDrugs-'+fieldId+'-manufacturer-0').after(manufacturerHtml);
    }
    $('table.manufacturerSupp-'+fieldId+':last').find('td.manufacturerTitle').hide();    
    $('table.manufacturerSupp-'+fieldId+':last').find('td.noManufacturerTitle').show();   
    $('#articleDrugs-'+fieldId+'-manufacturer-'+subFieldId+'-name').val('');
    $('#articleDrugs-'+fieldId+'-manufacturer-'+subFieldId+'-address').val('');    
    $('table.manufacturerSupp-'+fieldId+':last').find('a.removeManufacturer').show();
    $('table.manufacturerSupp-'+fieldId+':last').find('a.removeManufacturer').click(function(){$(this).closest('table').remove();});   
}
