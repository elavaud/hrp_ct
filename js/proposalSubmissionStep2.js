/* 
 * JS file containing all the functions used during the submission or the edition of clinical trials.
 * Step 2: Clinical Trial's Information
 */


function addSecId(){
    var secIdHtml = '<tr valign="top" class="secIdSupp">' + $('#firstSecId').html() + '</tr>';
    if ($("#secIds tr.secIdSupp")[0]){
        var selectName = $('#secIds tr.secIdSupp:last').find('select').attr('name');
        var selectNameStartRemoved = selectName.replace('articleSecIds[', '');
        var selectNameStartAndEndRemoved = selectNameStartRemoved.replace('][type]', '');
        var fieldId = parseInt(selectNameStartAndEndRemoved) + 1;
        $('#secIds tr.secIdSupp:last').after(secIdHtml);
        $('#secIds tr.secIdSupp:last').find('.hiddenInputs').remove();
        $('#secIds tr.secIdSupp:last').find('select').attr('selectedIndex', 0);
        $('#secIds tr.secIdSupp:last').find('select').attr('name', 'articleSecIds['+fieldId+'][type]');
        $('#secIds tr.secIdSupp:last').find('input').val('');
        $('#secIds tr.secIdSupp:last').find('input').attr('name', 'articleSecIds['+fieldId+'][id]');
        $('#secIds tr.secIdSupp:last').find('.removeSecId').show();
        $('#secIds tr.secIdSupp:last').find('.removeSecId').click(function(){$(this).closest('tr').remove();});
        $('#secIds tr.secIdSupp:last').find('.secIdTitle').hide();
        $('#secIds tr.secIdSupp:last').find('.noSecIdTitle').show();
    } else {
        var fieldId = 1;        
        $('#firstSecId').after(secIdHtml);
        $('#firstSecId').next().find('.hiddenInputs').remove();
        $('#firstSecId').next().find('select').attr('selectedIndex', 0);
        $('#firstSecId').next().find('select').attr('name', 'articleSecIds['+fieldId+'][type]');
        $('#firstSecId').next().find('input').val('');
        $('#firstSecId').next().find('input').attr('name', 'articleSecIds['+fieldId+'][id]');
        $('#secIds tr.secIdSupp').find('.removeSecId').show();
        $('#secIds tr.secIdSupp').find('.removeSecId').click(function(){$(this).closest('tr').remove();});
        $('#secIds tr.secIdSupp').find('.secIdTitle').hide();
        $('#secIds tr.secIdSupp').find('.noSecIdTitle').show();
    }              
}

function showOrHideOherTherapeuticAreaField(){
    var value = $("#therapeuticArea").val();
    if (value === 'OTHER') {
        $('#otherTherapeuticAreaField').show();
        if($('#otherTherapeuticArea').val() === "NA") {
            $('#otherTherapeuticArea').val("");
        }
    } else {
        $('#otherTherapeuticAreaField').hide();
        $('#otherTherapeuticArea').val("NA");
    }
}

function addHealthCond(){
    var healthCondHtml = '<tr valign="top" class="healthCondSupp">' + $('#firstHealthCond').html() + '</tr>';
    if ($("#healthConds tr.healthCondSupp")[0]){
        if ($("#healthConds tr.healthCondSupp").length < 19) {
            var selectName = $('#healthConds tr.healthCondSupp:last').find('select').attr('name');
            var selectNameStartRemoved = selectName.replace('articleDetails[healthConds][', '');
            var selectNameStartAndEndRemoved = selectNameStartRemoved.replace('][code]', '');
            var fieldId = parseInt(selectNameStartAndEndRemoved) + 1;
            $('#healthConds tr.healthCondSupp:last').after(healthCondHtml);
            $('#healthConds tr.healthCondSupp:last').find('select').attr('selectedIndex', 0);
            $('#healthConds tr.healthCondSupp:last').find('select').attr('name', 'articleDetails[healthConds]['+fieldId+'][code]');
            $('#healthConds tr.healthCondSupp:last').find('input').val('');
            $('#healthConds tr.healthCondSupp:last').find('input').attr('name', 'articleDetails[healthConds]['+fieldId+'][exactCode]');
            $('#healthConds tr.healthCondSupp:last').find('.removeHealthCond').show();
            $('#healthConds tr.healthCondSupp:last').find('.removeHealthCond').click(function(){$(this).closest('tr').remove();});
            $('#healthConds tr.healthCondSupp:last').find('.healthCondTitle').hide();
            $('#healthConds tr.healthCondSupp:last').find('.noHealthCondTitle').show();            
        }
    } else {
        var fieldId = 1;
        $('#firstHealthCond').after(healthCondHtml);
        $('#firstHealthCond').next().find('select').attr('selectedIndex', 0);
        $('#firstHealthCond').next().find('select').attr('name', 'articleDetails[healthConds]['+fieldId+'][code]');
        $('#firstHealthCond').next().find('input').val('');
        $('#firstHealthCond').next().find('input').attr('name', 'articleDetails[healthConds]['+fieldId+'][exactCode]');        
        $('#healthConds tr.healthCondSupp').find('.removeHealthCond').show();
        $('#healthConds tr.healthCondSupp').find('.removeHealthCond').click(function(){$(this).closest('tr').remove();});
        $('#healthConds tr.healthCondSupp').find('.healthCondTitle').hide();
        $('#healthConds tr.healthCondSupp').find('.noHealthCondTitle').show();
    }              
}

function addPurpose(){
    var purposeHtml = '<table valign="top" class="purposeSupp" width="100%">' + $('#firstPurpose').html() + '</table>';
    if ($("#purposes .purposeSupp").length){
        var selectName = $('#purposes table.purposeSupp:last').find('input:radio').attr('name');
        var selectNameStartRemoved = selectName.replace('purposes[', '');
        var selectNameStartAndEndRemoved = selectNameStartRemoved.replace('][interventional]', '');
        var fieldId = parseInt(selectNameStartAndEndRemoved) + 1;
    } else {
        var fieldId = 1;
    }
    while (purposeHtml.indexOf("purposes-0") > -1) {     
        purposeHtml = purposeHtml.replace('purposes-0', 'purposes-'+fieldId);
    }
    while (purposeHtml.indexOf("purposes[0") > -1) {     
        purposeHtml = purposeHtml.replace('purposes[0', 'purposes['+fieldId);
    }
    while (purposeHtml.indexOf('<a class="showHideHelpButton" style="cursor:pointer;">[?]</a> ') > -1) {     
        purposeHtml = purposeHtml.replace('<a class="showHideHelpButton" style="cursor:pointer;">[?]</a> ', '');           
    }
    if ($("#purposes .purposeSupp").length){        
        $('#purposes table.purposeSupp:last').after(purposeHtml);
        $('#purposes table.purposeSupp:last').find('.hiddenInputs').remove();
        $("#purposes table.purposeSupp:last").find('.showHideHelpField').remove('');
        $('#purposes table.purposeSupp:last').find('input:radio').each(function () {$(this).prop('checked', false)});
        if (!$('#purposes table.purposeSupp:last').find('tr[id*=-type]').find('select').find('option[value="NA"]').length > 0){
            $('#purposes table.purposeSupp:last').find('tr[id*=-type]').find('select').append('<option value="NA"></option>');
        }
        $('#purposes table.purposeSupp:last').find('tr[id*=-type]').find('select').val('NA');

        if (!$('#purposes table.purposeSupp:last').find('tr[id*=-ctPhase]').find('select').find('option[value="NA"]').length > 0){
            $('#purposes table.purposeSupp:last').find('tr[id*=-ctPhase]').find('select').append('<option value="NA"></option>');
        }
        $('#purposes table.purposeSupp:last').find('tr[id*=-ctPhase]').find('select').val('NA');

        if (!$('#purposes table.purposeSupp:last').find('tr[id*=-allocation]').find('select').find('option[value="NA"]').length > 0){
            $('#purposes table.purposeSupp:last').find('tr[id*=-allocation]').find('select').append('<option value="NA"></option>');
        }
        $('#purposes table.purposeSupp:last').find('tr[id*=-allocation]').find('select').val('NA');

        if (!$('#purposes table.purposeSupp:last').find('tr[id*=-masking]').find('select').find('option[value="NA"]').length > 0){
            $('#purposes table.purposeSupp:last').find('tr[id*=-masking]').find('select').append('<option value="NA"></option>');
        }
        $('#purposes table.purposeSupp:last').find('tr[id*=-masking]').find('select').val('NA');
        
        if (!$('#purposes table.purposeSupp:last').find('tr[id*=-control]').find('select').find('option[value="NA"]').length > 0){
            $('#purposes table.purposeSupp:last').find('tr[id*=-control]').find('select').append('<option value="NA"></option>');
        }
        $('#purposes table.purposeSupp:last').find('tr[id*=-control]').find('select').val('NA');
        
        if (!$('#purposes table.purposeSupp:last').find('tr[id*=-assignment]').find('select').find('option[value="NA"]').length > 0){
            $('#purposes table.purposeSupp:last').find('tr[id*=-assignment]').find('select').append('<option value="NA"></option>');
        }
        $('#purposes table.purposeSupp:last').find('tr[id*=-assignment]').find('select').val('NA');

        
        if (!$('#purposes table.purposeSupp:last').find('tr[id*=-endpoint]').find('select').find('option[value="NA"]').length > 0){
            $('#purposes table.purposeSupp:last').find('tr[id*=-endpoint]').find('select').append('<option value="NA"></option>');
        }
        $('#purposes table.purposeSupp:last').find('tr[id*=-endpoint]').find('select').val('NA');
                
        $('#purposes table.purposeSupp:last').find('.removePurpose').show();
        $('#purposes table.purposeSupp:last').find('.removePurpose').click(function(){$(this).closest('table').remove();});
        $('#purposes table.purposeSupp:last').find('.purposeTitle').hide();
        $('#purposes table.purposeSupp:last').find('.noPurposeTitle').show();
    } else {        
        $('#firstPurpose').after(purposeHtml);
        $('#firstPurpose').next().find('.hiddenInputs').remove();
        $('#firstPurpose').next().find('.showHideHelpField').remove('');
        if (!$('#firstPurpose').next().find('tr[id*=-type]').find('select').find('option[value="NA"]').length > 0){
            $('#firstPurpose').next().find('tr[id*=-type]').find('select').append('<option value="NA"></option>');
        }
        $('#firstPurpose').next().find('tr[id*=-type]').find('select').val('NA');

        if (!$('#firstPurpose').next().find('tr[id*=-ctPhase]').find('select').find('option[value="NA"]').length > 0){
            $('#firstPurpose').next().find('tr[id*=-ctPhase]').find('select').append('<option value="NA"></option>');
        }
        $('#firstPurpose').next().find('tr[id*=-ctPhase]').find('select').val('NA');

        if (!$('#firstPurpose').next().find('tr[id*=-allocation]').find('select').find('option[value="NA"]').length > 0){
            $('#firstPurpose').next().find('tr[id*=-allocation]').find('select').append('<option value="NA"></option>');
        }
        $('#firstPurpose').next().find('tr[id*=-allocation]').find('select').val('NA');

        if (!$('#firstPurpose').next().find('tr[id*=-masking]').find('select').find('option[value="NA"]').length > 0){
            $('#firstPurpose').next().find('tr[id*=-masking]').find('select').append('<option value="NA"></option>');
        }
        $('#firstPurpose').next().find('tr[id*=-masking]').find('select').val('NA');
        
        if (!$('#firstPurpose').next().find('tr[id*=-control]').find('select').find('option[value="NA"]').length > 0){
            $('#firstPurpose').next().find('tr[id*=-control]').find('select').append('<option value="NA"></option>');
        }
        $('#firstPurpose').next().find('tr[id*=-control]').find('select').val('NA');
        
        if (!$('#firstPurpose').next().find('tr[id*=-assignment]').find('select').find('option[value="NA"]').length > 0){
            $('#firstPurpose').next().find('tr[id*=-assignment]').find('select').append('<option value="NA"></option>');
        }
        $('#firstPurpose').next().find('tr[id*=-assignment]').find('select').val('NA');
        
        if (!$('#firstPurpose').next().find('tr[id*=-endpoint]').find('select').find('option[value="NA"]').length > 0){
            $('#firstPurpose').next().find('tr[id*=-endpoint]').find('select').append('<option value="NA"></option>');
        }
        $('#firstPurpose').next().find('tr[id*=-endpoint]').find('select').val('NA');
        $('#purposes table.purposeSupp').find('.removePurpose').show();
        $('#purposes table.purposeSupp').find('.removePurpose').click(function(){$(this).closest('table').remove();});
        $('#purposes table.purposeSupp').find('.purposeTitle').hide();
        $('#purposes table.purposeSupp').find('.noPurposeTitle').show();
        
    }      
    $("#purposes input[name*=interventional]").each(function() {$(this).change(showOrHideInterventionalFields);});
    showOrHideInterventionalFields();
}

function showOrHideInterventionalFields() {
    $("input[name*=interventional]").each(function () {
        var name = $(this).attr('name');
        var iterator = parseInt(name.slice(9,10));
        var value = $("input[name='"+name+"']:checked").val();
        var idTrType = "purposes-"+iterator+"-type";
        var idTrCTPhase = "purposes-"+iterator+"-ctPhase";
        var idTrAllocation = "purposes-"+iterator+"-allocation";    
        var idTrMasking = "purposes-"+iterator+"-masking";   
        var idTrControl = "purposes-"+iterator+"-control";   
        var idTrAssignment = "purposes-"+iterator+"-assignment";   
        var idTrEndpoint = "purposes-"+iterator+"-endpoint";  
        var idTrSeparator = "purposes-"+iterator+"-separator";          
        if(value == ARTICLE_PURPOSE_TYPE_INT){
            $('#' + idTrType).show();
            if ($('#' + idTrType).find('select').find('option[value="NA"]').length > 0){
                $('#' + idTrType).find('select').find('option[value="NA"]').remove();
            }
            $('#' + idTrCTPhase).show();
            if ($('#' + idTrCTPhase).find('select').find('option[value="NA"]').length > 0){
                $('#' + idTrCTPhase).find('select').find('option[value="NA"]').remove();
            }
            $('#' + idTrAllocation).show();
            if ($('#' + idTrAllocation).find('select').find('option[value="NA"]').length > 0){
                $('#' + idTrAllocation).find('select').find('option[value="NA"]').remove();
            }
            $('#' + idTrMasking).show();
            if ($('#' + idTrMasking).find('select').find('option[value="NA"]').length > 0){
                $('#' + idTrMasking).find('select').find('option[value="NA"]').remove();
            }
            $('#' + idTrControl).show();
            if ($('#' + idTrControl).find('select').find('option[value="NA"]').length > 0){
                $('#' + idTrControl).find('select').find('option[value="NA"]').remove();
            }
            $('#' + idTrAssignment).show();
            if ($('#' + idTrAssignment).find('select').find('option[value="NA"]').length > 0){
                $('#' + idTrAssignment).find('select').find('option[value="NA"]').remove();
            }
            $('#' + idTrEndpoint).show();
            if ($('#' + idTrEndpoint).find('select').find('option[value="NA"]').length > 0){
                $('#' + idTrEndpoint).find('select').find('option[value="NA"]').remove();
            }
            $('#' + idTrSeparator).show();
        } else {
            $('#' + idTrType).hide();
            if (!$('#' + idTrType).find('select').find('option[value="NA"]').length > 0){
                $('#' + idTrType).find('select').append('<option value="NA"></option>');
            }
            $('#' + idTrType).find('select').val('NA');
            $('#' + idTrCTPhase).hide();
            if (!$('#' + idTrCTPhase).find('select').find('option[value="NA"]').length > 0){
                $('#' + idTrCTPhase).find('select').append('<option value="NA"></option>');
            }
            $('#' + idTrCTPhase).find('select').val('NA');
            $('#' + idTrAllocation).hide();
            if (!$('#' + idTrAllocation).find('select').find('option[value="NA"]').length > 0){
                $('#' + idTrAllocation).find('select').append('<option value="NA"></option>');
            }
            $('#' + idTrAllocation).find('select').val('NA');
            $('#' + idTrMasking).hide();
            if (!$('#' + idTrMasking).find('select').find('option[value="NA"]').length > 0){
                $('#' + idTrMasking).find('select').append('<option value="NA"></option>');
            }
            $('#' + idTrMasking).find('select').val('NA');
            $('#' + idTrControl).hide();
            if (!$('#' + idTrControl).find('select').find('option[value="NA"]').length > 0){
                $('#' + idTrControl).find('select').append('<option value="NA"></option>');
            }
            $('#' + idTrControl).find('select').val('NA');
            $('#' + idTrAssignment).hide();
            if (!$('#' + idTrAssignment).find('select').find('option[value="NA"]').length > 0){
                $('#' + idTrAssignment).find('select').append('<option value="NA"></option>');
            }
            $('#' + idTrAssignment).find('select').val('NA');
            $('#' + idTrEndpoint).hide();
            if (!$('#' + idTrEndpoint).find('select').find('option[value="NA"]').length > 0){
                $('#' + idTrEndpoint).find('select').append('<option value="NA"></option>');
            }
            $('#' + idTrEndpoint).find('select').val('NA');
            $('#' + idTrSeparator).hide();
        }
    });
    
    
}

function addPrimaryOutcome(){
    if ($("#primaryOutcomes .primaryOutcomeSupp").length < 2) {
        var outcomeHtml = '<table valign="top" class="primaryOutcomeSupp" id="primaryOutcomes-X" width="100%">' + $('#primaryOutcomes-0').html() + '</table>';

        if ($("#primaryOutcomes .primaryOutcomeSupp").length){
            var selectName = $('#primaryOutcomes table.primaryOutcomeSupp:last').attr('id');            
            var selectNameStartRemoved = selectName.replace('primaryOutcomes-', '');
            var fieldId = parseInt(selectNameStartRemoved) + 1;
            outcomeHtml = outcomeHtml.replace('primaryOutcomes-X', 'primaryOutcomes-'+fieldId);
            while (outcomeHtml.indexOf("primaryOutcomes-0") > -1) {     
                outcomeHtml = outcomeHtml.replace('primaryOutcomes-0', 'primaryOutcomes-'+fieldId);
            }
            while (outcomeHtml.indexOf("primaryOutcomes[0") > -1) {     
                outcomeHtml = outcomeHtml.replace('primaryOutcomes[0', 'primaryOutcomes['+fieldId);
            }
            $('#primaryOutcomes table.primaryOutcomeSupp:last').after(outcomeHtml);
            $('#primaryOutcomes table.primaryOutcomeSupp:last').find('.hiddenInputs').remove('');
            $('#primaryOutcomes table.primaryOutcomeSupp:last').find('.showHideHelpField').remove('');
        } else {    
            var fieldId = 1;
            outcomeHtml = outcomeHtml.replace('primaryOutcomes-X', 'primaryOutcomes-1');
            while (outcomeHtml.indexOf("primaryOutcomes-0") > -1) {     
                outcomeHtml = outcomeHtml.replace('primaryOutcomes-0', 'primaryOutcomes-1');
            }
            while (outcomeHtml.indexOf("primaryOutcomes[0") > -1) {     
                outcomeHtml = outcomeHtml.replace('primaryOutcomes[0', 'primaryOutcomes[1');
            }
            $('#primaryOutcomes-0').after(outcomeHtml);
            $('#primaryOutcomes-0').next().find('.hiddenInputs').remove('');
            $('#primaryOutcomes-0').next().find('.showHideHelpField').remove('');
        }      
        $('#primaryOutcomes-'+fieldId+'-en_US-name').val('');
        $('#primaryOutcomes-'+fieldId+'-en_US-measurement').val('');
        $('#primaryOutcomes-'+fieldId+'-en_US-timepoint').val('');

        $('#primaryOutcomes-'+fieldId).find('.removePrimaryOutcome').show();
        $('#primaryOutcomes-'+fieldId).find('.removePrimaryOutcome').click(function(){$(this).closest('table').remove();});
        $('#primaryOutcomes-'+fieldId).find('.primaryOutcomeTitle').hide();
        $('#primaryOutcomes-'+fieldId).find('.noPrimaryOutcomeTitle').show();
    }
}

function addSecondaryOutcome(){
    var outcomeHtml = '<table valign="top" class="secondaryOutcomeSupp" id="secondaryOutcomes-X" width="100%">' + $('#secondaryOutcomes-0').html() + '</table>';

    if ($("#secondaryOutcomes .secondaryOutcomeSupp").length){
        var selectName = $('#secondaryOutcomes table.secondaryOutcomeSupp:last').attr('id');
        var selectNameStartRemoved = selectName.replace('secondaryOutcomes-', '');
        var fieldId = parseInt(selectNameStartRemoved) + 1;
        outcomeHtml = outcomeHtml.replace('secondaryOutcomes-X', 'secondaryOutcomes-'+fieldId);
        while (outcomeHtml.indexOf("secondaryOutcomes-0") > -1) {     
            outcomeHtml = outcomeHtml.replace('secondaryOutcomes-0', 'secondaryOutcomes-'+fieldId);
        }
        while (outcomeHtml.indexOf("secondaryOutcomes[0") > -1) {     
            outcomeHtml = outcomeHtml.replace('secondaryOutcomes[0', 'secondaryOutcomes['+fieldId);
        }
        $('#secondaryOutcomes table.secondaryOutcomeSupp:last').after(outcomeHtml);
        $('#secondaryOutcomes table.secondaryOutcomeSupp:last').find('.showHideHelpField').remove('');
    } else {    
        var fieldId = 1;
        outcomeHtml = outcomeHtml.replace('secondaryOutcomes-X', 'secondaryOutcomes-1');
        while (outcomeHtml.indexOf("secondaryOutcomes-0") > -1) {     
            outcomeHtml = outcomeHtml.replace('secondaryOutcomes-0', 'secondaryOutcomes-1');
        }
        while (outcomeHtml.indexOf("secondaryOutcomes[0") > -1) {     
            outcomeHtml = outcomeHtml.replace('secondaryOutcomes[0', 'secondaryOutcomes[1');
        }
        $('#secondaryOutcomes-0').after(outcomeHtml);
        $('#secondaryOutcomes-0').next().find('.showHideHelpField').remove('');
    }      
    $('#secondaryOutcomes-'+fieldId+'-en_US-name').val('');
    $('#secondaryOutcomes-'+fieldId+'-en_US-measurement').val('');
    $('#secondaryOutcomes-'+fieldId+'-en_US-timepoint').val('');

    $('#secondaryOutcomes-'+fieldId).find('.removeSecondaryOutcome').show();
    $('#secondaryOutcomes-'+fieldId).find('.removeSecondaryOutcome').click(function(){$(this).closest('table').remove();});
    $('#secondaryOutcomes-'+fieldId).find('.secondaryOutcomeTitle').hide();
    $('#secondaryOutcomes-'+fieldId).find('.noSecondaryOutcomeTitle').show();
}

function isNumeric(){
    var numericExpression = /^([\s]*[0-9]+[\s]*)+$/;
    $('input.numField').each(function() {
        if ($(this).val() != '') {
            if ($(this).val().match(numericExpression)){
                return true;
            } else {
                alert(AGE_NOT_NUMERIC);
                var input = $(this).val();
                for (var i = 0; i < input.length; i++) {
                    if (!input.charAt(i).match(numericExpression)) {
                        $(this).val($(this).val().replace(input.charAt(i), ''));
                    }
                }                
                $(this).focus();
                return false;
            }   
        } else {
            return true;
        }
    });
}

function addIntCountry(){
    var intCountryHtml = '<table class="countryAndSizeSupp" id="articleDetails-intSampleSize-X" width="100%">' + $('#articleDetails-intSampleSize-0').html() + '</table>';
    
    if ($("#intSampleSizeFields table.countryAndSizeSupp").length){
        var selectName = $('#intSampleSizeFields table.countryAndSizeSupp:last').attr('id');        
        var selectNameStartRemoved = selectName.replace('articleDetails-intSampleSize-', '');
        var fieldId = parseInt(selectNameStartRemoved) + 1;
        intCountryHtml = intCountryHtml.replace('articleDetails-intSampleSize-X', 'articleDetails-intSampleSize-'+fieldId);
        while (intCountryHtml.indexOf("articleDetails-intSampleSize-0") > -1) {     
            intCountryHtml = intCountryHtml.replace('articleDetails-intSampleSize-0', 'articleDetails-intSampleSize-'+fieldId);
        }
        while (intCountryHtml.indexOf("articleDetails[intSampleSize][0") > -1) {     
            intCountryHtml = intCountryHtml.replace('articleDetails[intSampleSize][0', 'articleDetails[intSampleSize]['+fieldId);
        }
        $('#intSampleSizeFields table.countryAndSizeSupp:last').after(intCountryHtml);
    } else {    
        var fieldId = 1;
        intCountryHtml = intCountryHtml.replace('articleDetails-intSampleSize-X', 'articleDetails-intSampleSize-1');
        while (intCountryHtml.indexOf("articleDetails-intSampleSize-0") > -1) {     
            intCountryHtml = intCountryHtml.replace('articleDetails-intSampleSize-0', 'articleDetails-intSampleSize-1');
        }
        while (intCountryHtml.indexOf("articleDetails[intSampleSize][0") > -1) {     
            intCountryHtml = intCountryHtml.replace('articleDetails[intSampleSize][0', 'articleDetails[intSampleSize][1');
        }
        $('#articleDetails-intSampleSize-0').after(intCountryHtml);
    }      
    $('#articleDetails-intSampleSize-'+fieldId+'-country').val('');
    $('#articleDetails-intSampleSize-'+fieldId+'-number').val('');

    $('#articleDetails-intSampleSize-'+fieldId).find('.removeIntCountry').show();
    $('#articleDetails-intSampleSize-'+fieldId).find('.removeIntCountry').click(function(){$(this).closest('table').remove();});
    $("input.numField").each(function() {$(this).keyup(isNumeric);});
    showOrHideOherIntSampleSizeField();
}

function showOrHideOherIntSampleSizeField(){
    var value = $("input[name=articleDetails[multinational]]:checked").val();
    if (value == ARTICLE_DETAIL_YES) {
        $('#addAnotherIntCountry').show();
        $('#articleDetails-intSampleSize-0').show();
        if ($('#articleDetails-intSampleSize-0-country').find('option[value="NA"]').length > 0){
            if($('#articleDetails-intSampleSize-0-country').val() == "NA") {
                $('#articleDetails-intSampleSize-0-country').val("");
            }
            $('#articleDetails-intSampleSize-0-country').find('option[value="NA"]').remove();
        }
        if ($('#articleDetails-intSampleSize-0-number').val() == "0") {
            $('#articleDetails-intSampleSize-0-number').val("");
        }
        $( "#intSampleSizeFields table.countryAndSizeSupp" ).each(function() {
            var selectName = $(this).attr('id');
            var fieldId = parseInt(selectName.slice(29,30));
            $('#articleDetails-intSampleSize-'+fieldId).show();
            if ($('#articleDetails-intSampleSize-'+fieldId+'-country').find('option[value="NA"]').length > 0){
                if($('#articleDetails-intSampleSize-'+fieldId+'-country').val() == "NA") {
                    $('#articleDetails-intSampleSize-'+fieldId+'-country').val("");
                }
                $('#articleDetails-intSampleSize-'+fieldId+'-country').find('option[value="NA"]').remove();
            }
            if ($('#articleDetails-intSampleSize-'+fieldId+'-number').val() == "0") {
                $('#articleDetails-intSampleSize-'+fieldId+'-number').val("");
            }
        });                
    } else {
        $('#addAnotherIntCountry').hide();
        $('#articleDetails-intSampleSize-0').hide();
        $('#articleDetails-intSampleSize-0-number').val("0");
        if (!$('#articleDetails-intSampleSize-0-country').find('option[value="NA"]').length > 0){
            $('#articleDetails-intSampleSize-0-country').append('<option value="NA"></option>');
        }
        $('#articleDetails-intSampleSize-0-country').val('NA');
        $('#intSampleSizeFields table.countryAndSizeSupp').remove('');        
    }
}    
