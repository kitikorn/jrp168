<??

07.
$strTo = "member@thaicreate.com";
08.
$strSubject = "Test Send Email";
09.
$strHeader = "From: webmaster@thaicreate.com";
10.
$strMessage = "My Body & My Description";
11.
$flgSend = @mail($strTo,$strSubject,$strMessage,$strHeader);  // @ = No Show Error //
12.
if($flgSend)
13.
{
14.
echo "Email Sending.";
15.
}
16.
else
17.
{
18.
echo "Email Can Not Send.";
19.
}
>