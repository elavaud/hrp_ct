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
    for (i = 0; i < 50; i++) { 
        siteHtml = siteHtml.replace('articleSites-0', 'articleSites-'+fieldId);
    }
    for (i = 0; i < 50; i++) { 
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
    $('#articleSites-'+fieldId+'-site').val('');
    $('#articleSites-'+fieldId+'-site').change(function(e) {var id = e.target.id;showOrHideSiteFields(id);});
    $('#articleSites-'+fieldId+'-siteName').val('');
    $('#articleSites-'+fieldId+'-siteAddress').val('');
    $('#articleSites-'+fieldId+'-siteCity').val('');
    $('#articleSites-'+fieldId+'-siteRegion').val('');
    $('#articleSites-'+fieldId+'-siteLicensure').val('');
    $('#articleSites-'+fieldId+'-siteAccreditation').val('');
    showOrHideAllSiteFields();
}


function showOrHideSiteFields(id){
    var idStartRemoved = id.replace('articleSites-', '');
    var idStartAndEndRemoved = idStartRemoved.replace('-site', '');
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
        $('#articleSites-'+fieldId+'-siteLicensureField').hide();
        $('#articleSites-'+fieldId+'-siteLicensure').val("NA");
        $('#articleSites-'+fieldId+'-siteAccreditationField').hide();
        $('#articleSites-'+fieldId+'-siteAccreditation').val("NA");
    }
}

function showOrHideAllSiteFields(){
    $("select[id*='-site']").each(
        function() {
           showOrHideSiteFields($(this).attr("id"));
        }
    );
}