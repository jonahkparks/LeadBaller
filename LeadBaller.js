var campaignsTest = 'br4n2s75h'; // Testing App - Campaigns table
var campaignsProd = 'brx55z77r'; // Production App - Campaigns table

function authenticateQuickBase(qbTable, prodInstance) {
    var internalTable = '';

    if (qbTable = 'campaigns') {
        internalTable = (prodInstance = "yes" ? campaignsProd : campaignsTest );
    }
    var headers = {
        'QB-Realm-Hostname': 'leadballer.quickbase.com',
        'Content-Type': 'application/json'
    };

    var authToken = '';

    $.ajax({
        url: 'https://api.quickbase.com/v1/auth/temporary/' + internalTable,
           method: 'GET',
           async: false,
        headers: headers,
        xhrFields: { withCredentials: true },
        success: function(result) {
            authToken = result.temporaryAuthorization;
        }
    })

}
