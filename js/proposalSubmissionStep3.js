/* 
 * JS file containing all the functions used during the submission or the edition of clinical trials.
 * Step 3: INVESTIGATIONAL DRUG PRODUCT INFORMATION
 */

function addDrugInfo(){
    var drugHtml = '<div class="drugSupp" id="articleDrugs-X">' + $('#articleDrugs-0').html() + '</div>';
    if ($(".drugSupp").length){
        var selectName = $('div.drugSupp:last').attr('id');
        var fieldId = parseInt(selectName.slice(13,14)) + 1;            
    } else {    
        var fieldId = 1;
    }     
    drugHtml = drugHtml.replace('articleDrugs-X', 'articleDrugs-'+fieldId);
    for (i = 0; i < 7; i++) { 
        drugHtml = drugHtml.replace('articleDrugs-0', 'articleDrugs-'+fieldId);
    }
    for (i = 0; i < 7; i++) { 
        drugHtml = drugHtml.replace('articleDrugs[0', 'articleDrugs['+fieldId);
    }
    if ($(".drugSupp").length){
        $('div.drugSupp:last').after(drugHtml);
    } else {
        $('#articleDrugs-0').after(drugHtml);
    }
    //alert($('#articleDrugs-'+fieldId+'-title').val());
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

}
