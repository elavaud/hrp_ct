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
}
