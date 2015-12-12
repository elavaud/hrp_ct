/* 
 * JS file containing all the functions used during the submission or the edition of clinical trials.
 * Step 4: PROPOSED CLINICAL TRIAL SITE(S) AND DETAILS OF INVESTIGATOR(S)
 */

function addSite(){
    var siteHtml = '<div class="siteSupp" id="articleSites-X">' + $('#articleSites-0').html() + '</div>';
    if ($(".siteSupp").length){
        var selectName = $('div.siteSupp:last').attr('id');
        var selectNameStartRemoved = selectName.replace('articleSites-', '');
        var fieldId = parseInt(selectNameStartRemoved) + 1;
    } else {    
        var fieldId = 1;
    }     
    siteHtml = siteHtml.replace('articleSites-X', 'articleSites-'+fieldId);
    
    while (siteHtml.indexOf("articleSites-0") > -1) {     
        siteHtml = siteHtml.replace('articleSites-0', 'articleSites-'+fieldId);
    }
    while (siteHtml.indexOf("articleSites[0") > -1) {     
        siteHtml = siteHtml.replace('articleSites[0', 'articleSites['+fieldId);
    }
    if ($(".siteSupp").length){
        $('div.siteSupp:last').after(siteHtml);
    } else {
        $('#articleSites-0').after(siteHtml);
    }
    $('div.siteSupp:last').find('.hiddenInputs').remove('');
    $('div.siteSupp:last').find('tr.showHideHelpField').remove('');
    $('div.siteSupp:last').find('a.showHideHelpButton').remove('');    
    $('#articleSites-'+fieldId).find('.removeSite').show();
    $('#articleSites-'+fieldId).find('.removeSite').click(function(){$(this).closest('div').remove();});   
    $('#articleSites-'+fieldId+'-title').html(fieldId+1);
    $('#articleSites-'+fieldId+'-siteSelect').val('');
    $('#articleSites-'+fieldId+'-siteSelect').change(function(e) {var id = e.target.id;showOrHideSiteFields(id);});
    $('#articleSites-'+fieldId+'-authority').val('');
    $('#articleSites-'+fieldId+'-primaryPhone').val('');
    $('#articleSites-'+fieldId+'-secondaryPhone').val('');
    $('#articleSites-'+fieldId+'-fax').val('');
    $('#articleSites-'+fieldId+'-email').val('');
    $('#articleSites-'+fieldId+'-subjectsNumber').val('');
    $('#articleSites-'+fieldId+'-subjectsNumber').keyup(isNumeric);
    $('div.siteSupp:last').find('table.investigatorSupp-0').remove('');
    $('div.siteSupp:last').find('input[id*=-firstName]').val('');    
    $('div.siteSupp:last').find('input[id*=-lastName]').val('');    
    $('div.siteSupp:last').find('input[id*=-expertise]').val('');    
    $('div.siteSupp:last').find('input[id*=-iPrimaryPhone]').val('');    
    $('div.siteSupp:last').find('input[id*=-iSecondaryPhone]').val('');    
    $('div.siteSupp:last').find('input[id*=-iFax]').val('');    
    $('div.siteSupp:last').find('input[id*=-iEmail]').val('');   
    $('div.siteSupp:last').find('a.addAnotherInvestigatorClick').click(function(e) {var id = e.target.id;addInvestigator(id);});       
    showOrHideAllSiteFields();
}


function showOrHideSiteFields(id){
    var idStartRemoved = id.replace('articleSites-', '');
    var idStartAndEndRemoved = idStartRemoved.replace('-siteSelect', '');
    var fieldId = parseInt(idStartAndEndRemoved);
    var value = $("#"+id).val();
    if (value === 'OTHER') {
        $('#articleSites-'+fieldId+'-siteNameField').show();
        if($('#articleSites-'+fieldId+'-siteName').val() === "NA") {
            $('#articleSites-'+fieldId+'-siteName').val("");
        }
        $('#articleSites-'+fieldId+'-siteAddressField').show();
        if($('#articleSites-'+fieldId+'-siteAddress').val() === "NA") {
            $('#articleSites-'+fieldId+'-siteAddress').val("");
        }
        $('#articleSites-'+fieldId+'-siteCityField').show();
        if($('#articleSites-'+fieldId+'-siteCity').val() === "NA") {
            $('#articleSites-'+fieldId+'-siteCity').val("");
        }
        $('#articleSites-'+fieldId+'-siteRegionField').show();
        if($('#articleSites-'+fieldId+'-siteRegion').find('option[value="NA"]').length > 0) {
            $('#articleSites-'+fieldId+'-siteRegion').find('option[value="NA"]').remove();
        }
        $('#articleSites-'+fieldId+'-siteLicensureField').show();
        if($('#articleSites-'+fieldId+'-siteLicensure').val() === "NA") {
            $('#articleSites-'+fieldId+'-siteLicensure').val("");
        }
        $('#articleSites-'+fieldId+'-siteAccreditationField').show();
        if($('#articleSites-'+fieldId+'-siteAccreditation').val() === "NA") {
            $('#articleSites-'+fieldId+'-siteAccreditation').val("");
        }
    } else {
        $('#articleSites-'+fieldId+'-siteNameField').hide();
        $('#articleSites-'+fieldId+'-siteName').val("NA");
        $('#articleSites-'+fieldId+'-siteAddressField').hide();
        $('#articleSites-'+fieldId+'-siteAddress').val("NA");
        $('#articleSites-'+fieldId+'-siteCityField').hide();
        $('#articleSites-'+fieldId+'-siteCity').val("NA");
        $('#articleSites-'+fieldId+'-siteRegionField').hide();        
        if (!$('#articleSites-'+fieldId+'-siteRegion').find('option[value="NA"]').length > 0){
            $('#articleSites-'+fieldId+'-siteRegion').append('<option value="NA"></option>');
        }
        $('#articleSites-'+fieldId+'-siteRegion').val('NA');
        $('#articleSites-'+fieldId+'-siteLicensureField').hide();
        $('#articleSites-'+fieldId+'-siteLicensure').val("NA");
        $('#articleSites-'+fieldId+'-siteAccreditationField').hide();
        $('#articleSites-'+fieldId+'-siteAccreditation').val("NA");
    }
}

function showOrHideAllSiteFields(){
    $("select[id*='-siteSelect']").each(
        function() {
           showOrHideSiteFields($(this).attr("id"));
        }
    );
}

function isNumeric(){
    var numericExpression = /^([\s]*[0-9]+[\s]*)+$/;
    $('input.numField').each(function() {
        if ($(this).val() != '') {
            if ($(this).val().match(numericExpression)){
                return true;
            } else {
                alert(NOT_NUMERIC);
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

function addInvestigator(id) {
    var idStartRemoved = id.replace('articleSites-', '');
    var idStartAndEndRemoved = idStartRemoved.replace('-addInvestigator', '');
    var fieldId = parseInt(idStartAndEndRemoved);
    
    var investigatorHtml = '<table width="100%" class="investigatorSupp-'+fieldId+'" id="articleSites-'+fieldId+'-investigators-X">' + $('#articleSites-'+fieldId+'-investigators-0').html() + '</table>';
    if ($("table.investigatorSupp-"+fieldId).length){
        var selectName = $('table.investigatorSupp-'+fieldId+':last').attr('id');
        var selectNameStartRemoved = selectName.replace('articleSites-'+fieldId+'-investigators-', '');
        var subFieldId = parseInt(selectNameStartRemoved) + 1;
    } else {    
        var subFieldId = 1;
    }     
    investigatorHtml = investigatorHtml.replace('articleSites-'+fieldId+'-investigators-X', 'articleSites-'+fieldId+'-investigators-'+subFieldId);
    while (investigatorHtml.indexOf("articleSites-"+fieldId+"-investigators-0") > -1) {     
        investigatorHtml = investigatorHtml.replace('articleSites-'+fieldId+'-investigators-0', 'articleSites-'+fieldId+'-investigators-'+subFieldId);
    }
    while (investigatorHtml.indexOf("articleSites["+fieldId+"][investigators][0") > -1) {     
        investigatorHtml = investigatorHtml.replace('articleSites['+fieldId+'][investigators][0', 'articleSites['+fieldId+'][investigators]['+subFieldId);
    }
    if ($("table.investigatorSupp-"+fieldId).length){
        $('table.investigatorSupp-'+fieldId+':last').after(investigatorHtml);
    } else {
        $('#articleSites-'+fieldId+'-investigators-0').after(investigatorHtml);
    }
    $('table.investigatorSupp-'+fieldId+':last').find('td.investigatorTitle').hide();    
    $('table.investigatorSupp-'+fieldId+':last').find('td.noInvestigatorTitle').show();  
    $('table.investigatorSupp-'+fieldId+':last').find('.hiddenInputs').remove('');
    $('#articleSites-'+fieldId+'-investigators-'+subFieldId+'-firstName').val('');
    $('#articleSites-'+fieldId+'-investigators-'+subFieldId+'-lastName').val('');   
    $('#articleSites-'+fieldId+'-investigators-'+subFieldId+'-expertise').val('');   
    $('#articleSites-'+fieldId+'-investigators-'+subFieldId+'-iPrimaryPhone').val('');
    $('#articleSites-'+fieldId+'-investigators-'+subFieldId+'-iSecondaryPhone').val('');   
    $('#articleSites-'+fieldId+'-investigators-'+subFieldId+'-iFax').val('');
    $('#articleSites-'+fieldId+'-investigators-'+subFieldId+'-iEmail').val('');   
    $('table.investigatorSupp-'+fieldId+':last').find('a.removeInvestigator').show();
    $('table.investigatorSupp-'+fieldId+':last').find('a.removeInvestigator').click(function(){$(this).closest('table').remove();});   
}



