/* 
 * JS file containing all the functions used during the submission or the edition of clinical trials.
 * Step 5: Sponsor information
 */


function showOrHideSourceLocation(name){
    var nameStartRemoved = name.replace('fundingSources[', '');
    var nameStartAndEndRemoved = nameStartRemoved.replace('][location]', '');
    var fieldId = parseInt(nameStartAndEndRemoved);
    var showLocationCountry = false;
    var showLocationInternational = false;    
    $('input:radio[name="'+name+'"]').each(
        function () {
            if ($(this).val() == INSTITUTION_NATIONAL) {
                if ($(this).is(':checked')) {
                    showLocationCountry = true;
                }
            } else if ($(this).val() == INSTITUTION_INTERNATIONAL) {
                if ($(this).is(':checked')) {
                    showLocationInternational = true;
                }
            }
        }
    );
    if (showLocationCountry) {
        $('#fundingSources-'+fieldId+'-locationCountryField').show();
        if ($('#fundingSources-'+fieldId+'-locationCountry').find('option[value="NA"]').length) {
            $('#fundingSources-'+fieldId+'-locationCountry').find('option[value="NA"]').remove();
        }
    } else {
        $('#fundingSources-'+fieldId+'-locationCountryField').hide();   
        if (!$('#fundingSources-'+fieldId+'-locationCountry').find('option[value="NA"]').length) {
            $('#fundingSources-'+fieldId+'-locationCountry').append('<option value="NA"></option>');
        }
        $('#fundingSources-'+fieldId+'-locationCountry').val('NA')
    }
    if (showLocationInternational) {
        $('#fundingSources-'+fieldId+'-locationInternationalField').show();
        if ($('#fundingSources-'+fieldId+'-locationInternational').find('option[value="NA"]').length) {
            $('#fundingSources-'+fieldId+'-locationInternational').find('option[value="NA"]').remove();
        }
    } else {
        $('#fundingSources-'+fieldId+'-locationInternationalField').hide();   
        if (!$('#fundingSources-'+fieldId+'-locationInternational').find('option[value="NA"]').length) {
            $('#fundingSources-'+fieldId+'-locationInternational').append('<option value="NA"></option>');
        }
        $('#fundingSources-'+fieldId+'-locationInternational').val('NA')
    }
}

function showOrHideSourceLocations(){
    $('input:radio[name*="[location]"]').each(
        function () {
            showOrHideSourceLocation($(this).attr("name"));
        }
    );
}

function showOrHideSourceInfo(id){
    var idStartRemoved = id.replace('fundingSources-', '');
    var idStartAndEndRemoved = idStartRemoved.replace('-institutionId', '');
    var fieldId = parseInt(idStartAndEndRemoved);
    var value = $("#"+id).val();
    if (value === 'OTHER') {
        $('#fundingSources-'+fieldId+'-nameField').show();
        if($('#fundingSources-'+fieldId+'-name').val() === "NA") {
            $('#fundingSources-'+fieldId+'-name').val("");
        }
        $('#fundingSources-'+fieldId+'-acronymField').show();
        if($('#fundingSources-'+fieldId+'-acronym').val() === "NA") {
            $('#fundingSources-'+fieldId+'-acronym').val("");
        }
        $('#fundingSources-'+fieldId+'-typeField').show();
        if($('#fundingSources-'+fieldId+'-type').find('option[value="NA"]').length > 0) {
            $('#fundingSources-'+fieldId+'-type').find('option[value="NA"]').remove();
        }
        $('#fundingSources-'+fieldId+'-locationField').show();
        if ($('#fundingSources-'+fieldId+'-locationRadioSupp').length) {
            $('#fundingSources-'+fieldId+'-locationRadioSupp').remove();
        }
    } else {
        $('#fundingSources-'+fieldId+'-nameField').hide();
        $('#fundingSources-'+fieldId+'-name').val("NA");
        $('#fundingSources-'+fieldId+'-acronymField').hide();
        $('#fundingSources-'+fieldId+'-acronym').val("NA");
        $('#fundingSources-'+fieldId+'-typeField').hide();        
        if (!$('#fundingSources-'+fieldId+'-type').find('option[value="NA"]').length > 0){
            $('#fundingSources-'+fieldId+'-type').append('<option value="NA"></option>');
        }
        $('#fundingSources-'+fieldId+'-type').val('NA');        
        $('#fundingSources-'+fieldId+'-locationField').hide();        
        if (!$('#fundingSources-'+fieldId+'-locationRadioSupp').length) {
            $('#fundingSources-'+fieldId+'-locationField').find('input:radio:first').parent().append($('<input type="radio" name="fundingSources['+fieldId+'][location]" id="fundingSources-'+fieldId+'-locationRadioSupp" value="NA">'));        
        }
        $('#fundingSources-'+fieldId+'-locationRadioSupp').attr('checked', 'checked');     
    }
    showOrHideSourceLocations();
}

function showOrHideSourcesInfo(){
    $("select[id*='-institutionId']").each(
        function() {
           showOrHideSourceInfo($(this).attr("id"));
        }
    );
}

function addFundingSource(){
    var sourceHtml = '<table width="100%" class="sourceSupp" id="fundingSources-X">' + $('#fundingSources-0').html() + '</table>';
    if ($(".sourceSupp").length){
        var selectName = $('table.sourceSupp:last').attr('id');
        var selectNameStartRemoved = selectName.replace('fundingSources-', '');
        var fieldId = parseInt(selectNameStartRemoved) + 1;
    } else {    
        var fieldId = 1;
    }     
    sourceHtml = sourceHtml.replace('fundingSources-X', 'fundingSources-'+fieldId);
    while (sourceHtml.indexOf("fundingSources-0") > -1) { 
        sourceHtml = sourceHtml.replace('fundingSources-0', 'fundingSources-'+fieldId);
    }
    while (sourceHtml.indexOf("fundingSources[0") > -1) { 
        sourceHtml = sourceHtml.replace('fundingSources[0', 'fundingSources['+fieldId);
    }
    if ($(".sourceSupp").length){
        $('table.sourceSupp:last').after(sourceHtml);
    } else {
        $('#fundingSources-0').after(sourceHtml);
    }
    $('table.sourceSupp:last').find('.hiddenInputs').remove('');
    $('table.sourceSupp:last').find('tr.showHideHelpField').remove('');
    $('table.sourceSupp:last').find('a.showHideHelpButton').remove('');  
    $('table.sourceSupp:last').find('td.sourceTitle').hide();  
    $('table.sourceSupp:last').find('td.noSourceTitle').show();      
    $('#fundingSources-'+fieldId).find('.removeFundingSource').show();
    $('#fundingSources-'+fieldId).find('.removeFundingSource').click(function(){$(this).closest('table').remove();});   
    $('#fundingSources-'+fieldId+'-institutionId').val('');       
    $('#fundingSources-'+fieldId+'-institutionId').change(function(e) {var id = e.target.id;showOrHideSourceInfo(id);});
    $('table.sourceSupp:last').find('input:radio[name*="[location]"]').each(function () {$(this).click(function(e) {var name = e.target.name;showOrHideSourceLocation(name);});});
    showOrHideSourcesInfo();
}


function showOrHidePSponsorLocation(){
    var showLocationCountry = false;
    var showLocationInternational = false;    
    $('input:radio[name="primarySponsor[location]"]').each(
        function () {
            if ($(this).val() == INSTITUTION_NATIONAL) {
                if ($(this).is(':checked')) {
                    showLocationCountry = true;
                }
            } else if ($(this).val() == INSTITUTION_INTERNATIONAL) {
                if ($(this).is(':checked')) {
                    showLocationInternational = true;
                }
            }
        }
    );
    if (showLocationCountry) {
        $('#primarySponsorLocationCountryField').show();
        if ($('#primarySponsor-locationCountry').find('option[value="NA"]').length) {
            $('#primarySponsor-locationCountry').find('option[value="NA"]').remove();
        }
    } else {
        $('#primarySponsorLocationCountryField').hide();   
        if (!$('#primarySponsor-locationCountry').find('option[value="NA"]').length) {
            $('#primarySponsor-locationCountry').append('<option value="NA"></option>');
        }
        $('#primarySponsor-locationCountry').val('NA')
    }
    if (showLocationInternational) {
        $('#primarySponsorLocationInternationalField').show();
        if ($('#primarySponsor-locationInternational').find('option[value="NA"]').length) {
            $('#primarySponsor-locationInternational').find('option[value="NA"]').remove();
        }
    } else {
        $('#primarySponsorLocationInternationalField').hide();   
        if (!$('#primarySponsor-locationInternational').find('option[value="NA"]').length) {
            $('#primarySponsor-locationInternational').append('<option value="NA"></option>');
        }
        $('#primarySponsor-locationInternational').val('NA')
    }
}

function showOrHidePSponsorInfo(){
    var value = $("#primarySponsor-institutionId").val();
    if (value === 'OTHER') {
        $('#primarySponsorNameField').show();
        if($('#primarySponsor-name').val() === "NA") {
            $('#primarySponsor-name').val("");
        }
        $('#primarySponsorAcronymField').show();
        if($('#primarySponsor-acronym').val() === "NA") {
            $('#primarySponsor-acronym').val("");
        }
        $('#primarySponsorTypeField').show();
        if($('#primarySponsor-type').find('option[value="NA"]').length > 0) {
            $('#primarySponsor-type').find('option[value="NA"]').remove();
        }        
        $('#primarySponsorLocationField').show();
        if ($('#primarySponsor-locationRadioSupp').length) {
            $('#primarySponsor-locationRadioSupp').remove();
        }
    } else {
        $('#primarySponsorNameField').hide();
        $('#primarySponsor-name').val("NA");
        $('#primarySponsorAcronymField').hide();
        $('#primarySponsor-acronym').val("NA");
        $('#primarySponsorTypeField').hide();        
        if (!$('#primarySponsor-type').find('option[value="NA"]').length > 0){
            $('#primarySponsor-type').append('<option value="NA"></option>');
        }
        $('#primarySponsor-type').val('NA');        
        $('#primarySponsorLocationField').hide();        
        if (!$('#primarySponsor-locationRadioSupp').length) {
            $('#primarySponsorLocationField').find('input:radio:first').parent().append($('<input type="radio" name="primarySponsor[location]" id="primarySponsor-locationRadioSupp" value="NA">'));        
        }
        $('#primarySponsor-locationRadioSupp').attr('checked', 'checked');     
    }
    showOrHidePSponsorLocation();
}


function showOrHideSSponsorLocation(name){
    var nameStartRemoved = name.replace('secondarySponsors[', '');
    var nameStartAndEndRemoved = nameStartRemoved.replace('][ssLocation]', '');
    var fieldId = parseInt(nameStartAndEndRemoved);
    var showLocationCountry = false;
    var showLocationInternational = false;    
    $('input:radio[name="'+name+'"]').each(
        function () {
            if ($(this).val() == INSTITUTION_NATIONAL) {
                if ($(this).is(':checked')) {
                    showLocationCountry = true;
                }
            } else if ($(this).val() == INSTITUTION_INTERNATIONAL) {
                if ($(this).is(':checked')) {
                    showLocationInternational = true;
                }
            }
        }
    );
    if (showLocationCountry) {
        $('#secondarySponsors-'+fieldId+'-ssLocationCountryField').show();
        if ($('#secondarySponsors-'+fieldId+'-ssLocationCountry').find('option[value="NA"]').length) {
            $('#secondarySponsors-'+fieldId+'-ssLocationCountry').find('option[value="NA"]').remove();
        }
    } else {
        $('#secondarySponsors-'+fieldId+'-ssLocationCountryField').hide();   
        if (!$('#secondarySponsors-'+fieldId+'-ssLocationCountry').find('option[value="NA"]').length) {
            $('#secondarySponsors-'+fieldId+'-ssLocationCountry').append('<option value="NA"></option>');
        }
        $('#secondarySponsors-'+fieldId+'-ssLocationCountry').val('NA')
    }
    if (showLocationInternational) {
        $('#secondarySponsors-'+fieldId+'-ssLocationInternationalField').show();
        if ($('#secondarySponsors-'+fieldId+'-ssLocationInternational').find('option[value="NA"]').length) {
            $('#secondarySponsors-'+fieldId+'-ssLocationInternational').find('option[value="NA"]').remove();
        }
    } else {
        $('#secondarySponsors-'+fieldId+'-ssLocationInternationalField').hide();   
        if (!$('#secondarySponsors-'+fieldId+'-ssLocationInternational').find('option[value="NA"]').length) {
            $('#secondarySponsors-'+fieldId+'-ssLocationInternational').append('<option value="NA"></option>');
        }
        $('#secondarySponsors-'+fieldId+'-ssLocationInternational').val('NA')
    }
}

function showOrHideSSponsorLocations(){
    $('input:radio[name*="[ssLocation]"]').each(
        function () {
            showOrHideSSponsorLocation($(this).attr("name"));
        }
    );
}

function showOrHideSSponsorInfo(id){
    var idStartRemoved = id.replace('secondarySponsors-', '');
    var idStartAndEndRemoved = idStartRemoved.replace('-ssInstitutionId', '');
    var fieldId = parseInt(idStartAndEndRemoved);
    var value = $("#"+id).val();
    if (value === 'OTHER') {
        $('#secondarySponsors-'+fieldId+'-ssNameField').show();
        if($('#secondarySponsors-'+fieldId+'-ssName').val() === "NA") {
            $('#secondarySponsors-'+fieldId+'-ssName').val("");
        }
        $('#secondarySponsors-'+fieldId+'-ssAcronymField').show();
        if($('#secondarySponsors-'+fieldId+'-ssAcronym').val() === "NA") {
            $('#secondarySponsors-'+fieldId+'-ssAcronym').val("");
        }
        $('#secondarySponsors-'+fieldId+'-typeField').show();
        if($('#secondarySponsors-'+fieldId+'-type').find('option[value="NA"]').length > 0) {
            $('#secondarySponsors-'+fieldId+'-type').find('option[value="NA"]').remove();
        }        
        $('#secondarySponsors-'+fieldId+'-ssLocationField').show();
        if ($('#secondarySponsors-'+fieldId+'-ssLocationRadioSupp').length) {
            $('#secondarySponsors-'+fieldId+'-ssLocationRadioSupp').remove();
        }
    } else {
        $('#secondarySponsors-'+fieldId+'-ssNameField').hide();
        $('#secondarySponsors-'+fieldId+'-ssName').val("NA");
        $('#secondarySponsors-'+fieldId+'-ssAcronymField').hide();
        $('#secondarySponsors-'+fieldId+'-ssAcronym').val("NA");
        $('#secondarySponsors-'+fieldId+'-ssTypeField').hide();        
        if (!$('#secondarySponsors-'+fieldId+'-ssType').find('option[value="NA"]').length > 0){
            $('#secondarySponsors-'+fieldId+'-ssType').append('<option value="NA"></option>');
        }
        $('#secondarySponsors-'+fieldId+'-ssType').val('NA');                
        $('#secondarySponsors-'+fieldId+'-ssLocationField').hide();        
        if (!$('#secondarySponsors-'+fieldId+'-ssLocationRadioSupp').length) {
            $('#secondarySponsors-'+fieldId+'-ssLocationField').find('input:radio:first').parent().append($('<input type="radio" name="secondarySponsors['+fieldId+'][ssLocation]" id="secondarySponsors-'+fieldId+'-ssLocationRadioSupp" value="NA">'));        
        }
        $('#secondarySponsors-'+fieldId+'-ssLocationRadioSupp').attr('checked', 'checked');     
    }
    showOrHideSSponsorLocations();
}

function showOrHideSSponsorsInfo(){
    $("select[id*='-ssInstitutionId']").each(
        function() {
           showOrHideSSponsorInfo($(this).attr("id"));
        }
    );
}

function addSecondarySponsor(){
    var sSponsorHtml = '<table width="100%" class="sSponsorSupp" id="secondarySponsors-X">' + $('#secondarySponsors-0').html() + '</table>';
    if ($(".sSponsorSupp").length){
        var selectName = $('table.sSponsorSupp:last').attr('id');
        var selectNameStartRemoved = selectName.replace('secondarySponsors-', '');
        var fieldId = parseInt(selectNameStartRemoved) + 1;
    } else {    
        var fieldId = 1;
    }     
    sSponsorHtml = sSponsorHtml.replace('secondarySponsors-X', 'secondarySponsors-'+fieldId);
    while (sSponsorHtml.indexOf("secondarySponsors-0") > -1) { 
        sSponsorHtml = sSponsorHtml.replace('secondarySponsors-0', 'secondarySponsors-'+fieldId);
    }
    while (sSponsorHtml.indexOf("secondarySponsors[0") > -1) { 
        sSponsorHtml = sSponsorHtml.replace('secondarySponsors[0', 'secondarySponsors['+fieldId);
    }
    if ($(".sSponsorSupp").length){
        $('table.sSponsorSupp:last').after(sSponsorHtml);
    } else {
        $('#secondarySponsors-0').after(sSponsorHtml);
    }
    $('table.sSponsorSupp:last').find('.hiddenInputs').remove('');
    $('table.sSponsorSupp:last').find('tr.showHideHelpField').remove('');
    $('table.sSponsorSupp:last').find('a.showHideHelpButton').remove('');  
    $('table.sSponsorSupp:last').find('td.sSponsorTitle').hide();  
    $('table.sSponsorSupp:last').find('td.noSSponsorTitle').show();      
    $('#secondarySponsors-'+fieldId).find('.removeSecondarySponsor').show();
    $('#secondarySponsors-'+fieldId).find('.removeSecondarySponsor').click(function(){$(this).closest('table').remove();});   
    $('#secondarySponsors-'+fieldId+'-ssInstitutionId').val('');       
    $('#secondarySponsors-'+fieldId+'-ssInstitutionId').change(function(e) {var id = e.target.id;showOrHideSSponsorInfo(id);});
    $('table.sSponsorSupp:last').find('input:radio[name*="[ssLocation]"]').each(function () {$(this).click(function(e) {var name = e.target.name;showOrHideSSponsorLocation(name);});});
    showOrHideSSponsorsInfo();
}

function showOrHideCROLocation(name){
    var nameStartRemoved = name.replace('CROs[', '');
    var nameStartAndEndRemoved = nameStartRemoved.replace('][croLocation]', '');
    var fieldId = parseInt(nameStartAndEndRemoved);
    var showLocationCountry = false;
    var showLocationInternational = false;    
    $('input:radio[name="'+name+'"]').each(
        function () {
            if ($(this).val() == CRO_NATIONAL) {
                if ($(this).is(':checked')) {
                    showLocationCountry = true;
                }
            } else if ($(this).val() == CRO_INTERNATIONAL) {
                if ($(this).is(':checked')) {
                    showLocationInternational = true;
                }
            }
        }
    );
    if (showLocationCountry) {
        $('#CROs-'+fieldId+'-croLocationCountryField').show();
        if ($('#CROs-'+fieldId+'-croLocationCountry').find('option[value="NA"]').length) {
            $('#CROs-'+fieldId+'-croLocationCountry').find('option[value="NA"]').remove();
        }
    } else {
        $('#CROs-'+fieldId+'-croLocationCountryField').hide();   
        if (!$('#CROs-'+fieldId+'-croLocationCountry').find('option[value="NA"]').length) {
            $('#CROs-'+fieldId+'-croLocationCountry').append('<option value="NA"></option>');
        }
        $('#CROs-'+fieldId+'-croLocationCountry').val('NA')
    }
    if (showLocationInternational) {
        $('#CROs-'+fieldId+'-croLocationInternationalField').show();
        if ($('#CROs-'+fieldId+'-croLocationInternational').find('option[value="NA"]').length) {
            $('#CROs-'+fieldId+'-croLocationInternational').find('option[value="NA"]').remove();
        }
    } else {
        $('#CROs-'+fieldId+'-croLocationInternationalField').hide();   
        if (!$('#CROs-'+fieldId+'-croLocationInternational').find('option[value="NA"]').length) {
            $('#CROs-'+fieldId+'-croLocationInternational').append('<option value="NA"></option>');
        }
        $('#CROs-'+fieldId+'-croLocationInternational').val('NA')
    }
}

function showOrHideCROsLocations(){
    $('input:radio[name*="[croLocation]"]').each(
        function () {
            showOrHideCROLocation($(this).attr("name"));
        }
    );
}

function showOrHideCROInfo(){
    var value = $("input[name=croInvolved]:checked").val();
    if (value == ARTICLE_DETAIL_YES) {
        $('#addCROField').show();   
        $('#CROs-0').show();
        $('#CROs-0-croNameField').show();
        if($('#CROs-0-croName').val() === "NA") {
            $('#CROs-0-croName').val("");
        }
        $('#CROs-0-croLocationField').show();
        if ($('#CROs-0-croLocationRadioSupp').length) {
            $('#CROs-0-croLocationRadioSupp').remove();
        }
        $('#CROs-0-cityField').show();
        if($('#CROs-0-city').val() === "NA") {
            $('#CROs-0-city').val("");
        }
        $('#CROs-0-addressField').show();
        if($('#CROs-0-address').val() === "NA") {
            $('#CROs-0-address').val("");
        }
        $('#CROs-0-primaryPhoneField').show();
        if($('#CROs-0-primaryPhone').val() === "NA") {
            $('#CROs-0-primaryPhone').val("");
        }
        $('#CROs-0-secondaryPhoneField').show();
        if($('#CROs-0-secondaryPhone').val() === "NA") {
            $('#CROs-0-secondaryPhone').val("");
        }
        $('#CROs-0-faxField').show();
        if($('#CROs-0-fax').val() === "NA") {
            $('#CROs-0-fax').val("");
        }
        $('#CROs-0-emailField').show();
        if($('#CROs-0-email').val() === "NA") {
            $('#CROs-0-email').val("");
        }
        $( "#table.CROSupp" ).each(function() {
            var selectName = $(this).attr('id');
            var fieldId = parseInt(selectName.replace('CROs-', ''));
            $('#CROs-'+fieldId).show();
            $('#CROs-'+fieldId+'-croNameField').show();
            if($('#CROs-'+fieldId+'-croName').val() === "NA") {
                $('#CROs-'+fieldId+'-croName').val("");
            }
            $('#CROs-'+fieldId+'-croLocationField').show();
            if ($('#CROs-'+fieldId+'-croLocationRadioSupp').length) {
                $('#CROs-'+fieldId+'-croLocationRadioSupp').remove();
            }
            $('#CROs-'+fieldId+'-cityField').show();
            if($('#CROs-'+fieldId+'-city').val() === "NA") {
                $('#CROs-'+fieldId+'-city').val("");
            }
            $('#CROs-'+fieldId+'-addressField').show();
            if($('#CROs-'+fieldId+'-address').val() === "NA") {
                $('#CROs-'+fieldId+'-address').val("");
            }
            $('#CROs-'+fieldId+'-primaryPhoneField').show();
            if($('#CROs-'+fieldId+'-primaryPhone').val() === "NA") {
                $('#CROs-'+fieldId+'-primaryPhone').val("");
            }
            $('#CROs-'+fieldId+'-secondaryPhoneField').show();
            if($('#CROs-'+fieldId+'-secondaryPhone').val() === "NA") {
                $('#CROs-'+fieldId+'-secondaryPhone').val("");
            }
            $('#CROs-'+fieldId+'-faxField').show();
            if($('#CROs-'+fieldId+'-fax').val() === "NA") {
                $('#CROs-'+fieldId+'-fax').val("");
            }
            $('#CROs-'+fieldId+'-emailField').show();
            if($('#CROs-'+fieldId+'-email').val() === "NA") {
                $('#CROs-'+fieldId+'-email').val("");
            }
        });                        
    } else {
        $( "#table.CROSupp" ).remove();
        $('#addCROField').hide();   
        $('#CROs-0').hide();
        $('#CROs-0-croNameField').hide();
        $('#CROs-0-croName').val("NA");
        $('#CROs-0-croLocationField').hide();
        if (!$('#CROs-0-croLocationRadioSupp').length) {
            $('#CROs-0-croLocationField').find('input:radio:first').parent().append($('<input type="radio" name="CROs[0][croLocation]" id="CROs-0-croLocationRadioSupp" value="NA">'));        
        }
        $('#CROs-0-croLocationRadioSupp').attr('checked', 'checked');     
        $('#CROs-0-cityField').hide();
        $('#CROs-0-city').val("NA");
        $('#CROs-0-addressField').hide();
        $('#CROs-0-address').val("NA");
        $('#CROs-0-primaryPhoneField').hide();
        $('#CROs-0-primaryPhone').val("NA");
        $('#CROs-0-secondaryPhoneField').hide();
        $('#CROs-0-secondaryPhone').val("NA");
        $('#CROs-0-faxField').hide();
        $('#CROs-0-fax').val("NA");
        $('#CROs-0-emailField').hide();
        $('#CROs-0-email').val("NA");
    }
    showOrHideCROsLocations();
}

function addCRO(){
    var croHtml = '<table width="100%" class="CROSupp" id="CROs-X">' + $('#CROs-0').html() + '</table>';
    if ($(".CROSupp").length){
        var selectName = $('table.CROSupp:last').attr('id');
        var selectNameStartRemoved = selectName.replace('CROs-', '');
        var fieldId = parseInt(selectNameStartRemoved) + 1;
    } else {    
        var fieldId = 1;
    }     
    croHtml = croHtml.replace('CROs-X', 'CROs-'+fieldId);
    while (croHtml.indexOf("CROs-0") > -1) { 
        croHtml = croHtml.replace('CROs-0', 'CROs-'+fieldId);
    }
    while (croHtml.indexOf("CROs[0") > -1) { 
        croHtml = croHtml.replace('CROs[0', 'CROs['+fieldId);
    }
    if ($(".CROSupp").length){
        $('table.CROSupp:last').after(croHtml);
    } else {
        $('#CROs-0').after(croHtml);
    }
    $('table.CROSupp:last').find('.hiddenInputs').remove('');
    $('table.CROSupp:last').find('tr.showHideHelpField').remove('');
    $('table.CROSupp:last').find('a.showHideHelpButton').remove('');  
    $('#CROs-'+fieldId).find('.removeCRO').show();
    $('#CROs-'+fieldId).find('.removeCRO').click(function(){$(this).closest('table').remove();});   
    $('#CROs-'+fieldId+'-croNameField').show();
    $('#CROs-'+fieldId+'-croName').val("");    
    $('#CROs-'+fieldId+'-croLocationField').show();
    if ($('#CROs-'+fieldId+'-croLocationRadioSupp').length) {
        $('#CROs-'+fieldId+'-croLocationRadioSupp').remove();
    }
    $('table.CROSupp:last').find('input:radio[name*="[croLocation]"]').each(function () {$(this).click(function(e) {var name = e.target.name;showOrHideCROLocation(name);});});
    $('#CROs-'+fieldId+'-cityField').show();
    $('#CROs-'+fieldId+'-city').val("");
    $('#CROs-'+fieldId+'-addressField').show();
    $('#CROs-'+fieldId+'-address').val("");
    $('#CROs-'+fieldId+'-primaryPhoneField').show();
    $('#CROs-'+fieldId+'-primaryPhone').val("");
    $('#CROs-'+fieldId+'-secondaryPhoneField').show();
    $('#CROs-'+fieldId+'-secondaryPhone').val("");
    $('#CROs-'+fieldId+'-faxField').show();
    $('#CROs-'+fieldId+'-fax').val("");
    $('#CROs-'+fieldId+'-emailField').show();
    $('#CROs-'+fieldId+'-email').val("");
    showOrHideCROsLocations()();
}
