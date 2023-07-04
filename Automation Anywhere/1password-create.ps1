using namespace System.Management.Automation.Host

function Get-Pwd {
    [CmdletBinding()]
    param (
        [Parameter(Mandatory)]
        [ValidateNotNullOrEmpty()]
        [string]$Pwd
    )
    $options = [system.collections.generic.list[ChoiceDescription]]::new()
}
Invoke-Expression $(op signin)
