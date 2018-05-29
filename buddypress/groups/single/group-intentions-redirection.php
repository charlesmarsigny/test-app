<script>
var cpt = 8 ;
var x ;

function decompte()
{
	if(cpt>=0) {
		document.getElementById("chrono").innerHTML = "Vous allez être redirigez vers les intentions <br><b>dans " + cpt + " secondes.</b>" ;
		cpt-- ;
		x = setTimeout("decompte()",1000) ;
	}
	else {
		clearTimeout(x) ;
		window.location.href = "https://app.welikestartup.io/startup/<?=$group_slug?>/#intentions";
	}
}
</script>
<div class="message-warning">
	
	<i class="fa fa-info-circle icone-huge" aria-hidden="true"></i>
	<h3>Redirection</h3>

    <p>Les intentions se trouvent dès à présent au sein de la page startup.</p>
	<p id="chrono"></p>
	<br>
    <a class="button" href="https://app.welikestartup.io/startup/<?=$group_slug?>/#intentions">Accéder aux intentions</a>

</div>
<script>decompte();</script>