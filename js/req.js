
function color() {
	var str = document.getElementsByClassName('dispo');
	for (i = 0; i < str.length; i++) {
	  document.getElementById(i).style.color = 'white';
	  if (str[i].innerHTML=='Disponible') {
	    document.getElementById(i).style.backgroundColor = 'rgba(71, 170, 20, 1)';
	  }
	  else {
	    document.getElementById(i).style.backgroundColor = 'rgba(232, 97, 48, 0.93)';
	  }
	}
}

function rechercheLivre() {
	var input, filter, table, tr, td, i;
	input = document.getElementById("inputRecherche");
	filter = input.value.toUpperCase();
	table = document.getElementById("myTable");
	tr = table.getElementsByTagName("tr");
	for (i = 0; i < tr.length; i++) {
		td = tr[i].getElementsByTagName("td")[1];
		if (td) {
			if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
			} else {
				tr[i].style.display = "none";
			}
		}
	}
}
function rechercheUsager(){
	var input, filter, table, tr, td, i;
	input = document.getElementById("inputRechercheUsager");
	filter = input.value.toUpperCase();
	table = document.getElementById("myTableUsager");
	tr = table.getElementsByTagName("tr");
	for (i = 0; i < tr.length; i++) {
		td = tr[i].getElementsByTagName("td")[1];
		if (td) {
			if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
			} else {
				tr[i].style.display = "none";
			}
		}
	}
}

function requestIsbn(callback) {
	var xhr = getXMLHttpRequest();

	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			//callback(xhr.responseText);
			info(xhr.responseText,'reponse');
		}
	};

	var isbn = encodeURIComponent(document.getElementById("isbnn").value);

	//	var name = encodeURIComponent(document.getElementById("name").value);

	xhr.open("GET", "ajouterouvrage.php?isbn=" + isbn, true);
	xhr.send(null);
	setTimeout(creeouvragePc,1000);
	setTimeout(retourExemplaireExistant,1000);
}

function requestEmprunt(callback) {
	var xhr = getXMLHttpRequest();

	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			//callback(xhr.responseText);
			info(xhr.responseText,'reponse');
		}
	};

	var isbn = encodeURIComponent(document.getElementById("isbnn").value);

	xhr.open("GET", "ajouterexemplairePc.php?isbn=" + isbn, true);
	xhr.send(null);
}

function requestEmprunterLivre(callback) {
	var xhr = getXMLHttpRequest();

	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			//callback(xhr.responseText);
			info(xhr.responseText,'reponseEmprunterLivre');

		}
	};

	var livreid = encodeURIComponent(document.getElementById("livreid").value);
	var user = encodeURIComponent(document.getElementById("numusager").value);

	xhr.open("GET", "empruntPc.php?user=" + user + "&livre= " + livreid, true);
	xhr.send(null);
}

function requestInfoRendre(callback) {
	var xhr = getXMLHttpRequest();

	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			//callback(xhr.responseText);
			info(xhr.responseText,'reponseRendreLivre');

		}
	};

	var livreid = encodeURIComponent(document.getElementById("rendreid").value);

	xhr.open("GET", "inforestitutionPc.php?livre=" + livreid, true);
	xhr.send(null);
}

function requestInfoSupprimer(callback) {
	var xhr = getXMLHttpRequest();

	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			//callback(xhr.responseText);
			info(xhr.responseText,'reponseSupprimerLivre');

		}
	};

	var livreid = encodeURIComponent(document.getElementById("supprimerid").value);

	xhr.open("GET", "inforestitutionPc.php?livre=" + livreid, true);
	xhr.send(null);
}

function requestRendreLivre(callback) {
	var xhr = getXMLHttpRequest();

	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			//callback(xhr.responseText);
			info(xhr.responseText,'reponseRendreLivre');

		}
	};

	var livreid = encodeURIComponent(document.getElementById("rendreid").value);

	xhr.open("GET", "restitutionPc.php?livre=" + livreid, true);
	xhr.send(null);
}

function requestSupprimerLivre(callback) {
	var xhr = getXMLHttpRequest();

	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			//callback(xhr.responseText);
			info(xhr.responseText,'reponseSupprimerLivre');

		}
	};

	var livreid = encodeURIComponent(document.getElementById("supprimerid").value);

	xhr.open("GET", "supprimerexemplaire.php?ex=" + livreid, true);
	xhr.send(null);
}

function requestExemplaire(callback) {
	var xhr = getXMLHttpRequest();

	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			//callback(xhr.responseText);
			info(xhr.responseText,'recap');
			color();
		}
	};

	//	var name = encodeURIComponent(document.getElementById("name").value);

	xhr.open("GET", "getAllExemplaire.php", true);
	xhr.send(null);

}
function creeouvrageXMLHTTP(callback) {
	var xhr = getXMLHttpRequest();

	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			//callback(xhr.responseText);
			info(xhr.responseText,'reponse');

		}
	};

		var titre = encodeURIComponent(document.getElementById("titre").value);
		var auteur = encodeURIComponent(document.getElementById("auteur").value);
		var date = encodeURIComponent(document.getElementById("date").value);
		var isbn10 = encodeURIComponent(document.getElementById("isbn10").value);
		var isbn13 = encodeURIComponent(document.getElementById("isbn13").value);



	xhr.open("GET", "creeouvragePc.php?titre="+titre+"&auteur="+auteur+"&date="+date+"&isbn10="+isbn10+"&isbn13="+isbn13, true);
	xhr.send(null);

}
function requestRetard(callback) {
	var xhr = getXMLHttpRequest();

	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			//callback(xhr.responseText);
			info(xhr.responseText,'retard');
		}
	};

	//	var name = encodeURIComponent(document.getElementById("name").value);

	xhr.open("GET", "retard.php", true);
	xhr.send(null);
}

function adapt(){
	var a=document.getElementById('myTable').clientHeight;
	document.getElementById('dim').style.height = a+200+"px";
}

function ajouterUsager(){
	var xhr = getXMLHttpRequest();

	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			//callback(xhr.responseText);
			info(xhr.responseText,'reponseUsager');

		}
	};


	var nom = encodeURIComponent(document.getElementById("usagernom").value);
	var prenom = encodeURIComponent(document.getElementById("usagerprenom").value);
	var datenais = encodeURIComponent(document.getElementById("usagerdatenais").value);
	var genre = encodeURIComponent(document.getElementById("sexeusager").value);
	var type = encodeURIComponent(document.getElementById("typeusager").value);



	xhr.open("GET", "ajouterusager.php?nomusager="+nom+"&prenomusager="+prenom+"&datenaisusager="+datenais+"&sexeusager="+genre+"&typeusager="+type, true);
	xhr.send(null);
}

function supprimerUsager(){
	var xhr = getXMLHttpRequest();

	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			//callback(xhr.responseText);
			info(xhr.responseText,'reponseSupprimerUsager');

		}
	};

	var id = encodeURIComponent(document.getElementById("champsuprid").value);

	xhr.open("GET", "supprimerusager.php?usagerid="+id, true);
	xhr.send(null);
}

function ajouterexemplaireExistant(){
	var xhr = getXMLHttpRequest();

	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			//callback(xhr.responseText);
			info(xhr.responseText,'reponse');

		}
	};

	var id = encodeURIComponent(document.getElementById("idouvrageex").value);

	xhr.open("GET", "ajouterexemplaireexistant.php?id="+id, true);
	xhr.send(null);
}


	function requestUsager(){
		var xhr = getXMLHttpRequest();

		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
				//callback(xhr.responseText);
				info(xhr.responseText,'recapUsager');

			}
		};

		xhr.open("GET", "getallusager.php?", true);
		xhr.send(null);
	}

// *********************************************************************************************

function info(info,s) {
  what();
  function what(){
    var a=info;
		var b= s;
    document.getElementById(b).innerHTML = a;
  };
}


// Fonction pour appliquer le patern à l'event onclick avec en id l'id du bouton et message = input
document.getElementById('recherche').addEventListener('click', function() {
	document.getElementById('effacer').style.display = "inline";
if (document.getElementById('isbnn').checkValidity()) {
  document.getElementById('validerisbn').style.display = "none";
	requestIsbn(info);
} else {
  //window.alert('invalid station name!');
	info('Format invalide !' , 'reponse')
}
});

document.getElementById('effacer').addEventListener('click', function() {
	document.getElementById('reponse').innerHTML = "";
	document.getElementById('validerisbn').style.display = "none";
	document.getElementById('effacer').style.display = "none";
});
//*********************************************************************
//Pour emprunter livre

document.getElementById('effacerEmprunt').addEventListener('click', function() {
	document.getElementById('reponseEmprunterLivre').innerHTML = "";
	document.getElementById('effacerEmprunt').style.display = "none";
});

document.getElementById('validerEmprunt').addEventListener('click', function() {
	document.getElementById('effacerEmprunt').style.display = "inline";
if (document.getElementById('livreid').checkValidity() && document.getElementById('numusager').checkValidity()) {
  document.getElementById('validerEmprunt').style.display = "inline";
	//alert('ça marche');
} else {
  //window.alert('invalid station name!');
	info('Format invalide !', 'reponseEmprunterLivre');
}
});

function creeouvragePc(){
document.getElementById('emprunt').addEventListener('click', function() {
  document.getElementById('validerEmprunt').style.display = "inline";
	//alert('ça marche');
	creeouvrageXMLHTTP();

});
}
//**************************************************************************
//Pour rendre un livre
document.getElementById('rechercheRendre').addEventListener('click', function() {
	document.getElementById('effacerRendre').style.display = "inline";
if (document.getElementById('rendreid').checkValidity()) {
  document.getElementById('validerRendre').style.display = "inline";
	requestInfoRendre(info);
} else {
  //window.alert('invalid station name!');
	info('Format invalide !' , 'reponseRendreLivre')
}
});

document.getElementById('effacerRendre').addEventListener('click', function() {
	document.getElementById('reponseRendreLivre').innerHTML = "";
	document.getElementById('validerRendre').style.display = "none";
	document.getElementById('effacerRendre').style.display = "none";
});

//*******************************************************************************
//Pour supprimer un exemplaire
document.getElementById('rechercheSupprimer').addEventListener('click', function() {
	document.getElementById('effacerSupprimer').style.display = "inline";
if (document.getElementById('supprimerid').checkValidity()) {
  document.getElementById('validerSupprimer').style.display = "inline";
	requestInfoSupprimer(info);
} else {
  //window.alert('invalid station name!');
	info('Format invalide !' , 'reponseSupprimerLivre')
}
});

document.getElementById('effacerSupprimer').addEventListener('click', function() {
	document.getElementById('reponseSupprimerLivre').innerHTML = "";
	document.getElementById('validerSupprimer').style.display = "none";
	document.getElementById('effacerSupprimer').style.display = "none";
});


document.getElementById('refreshex').addEventListener('click', function() {
	requestExemplaire();
	//setTimeout(adapt, 250);
	//adapt();

});
document.getElementById('refreshretard').addEventListener('click', function() {
	requestRetard();
});
document.getElementById('refreshusagers').addEventListener('click', function() {
	requestUsager();
});


// ***************************************************************
// ajouter usager
document.getElementById('ajouterusagerbut').addEventListener('click', function() {
if (document.getElementById('usagernom').checkValidity() && document.getElementById('usagerprenom').checkValidity()&& document.getElementById('usagerdatenais').checkValidity()) {
	ajouterUsager(info);
} else {
	alert('Format invalide !');
}
});
document.getElementById('recommencerusager').addEventListener('click', function() {
document.getElementById('reponseUsager').innerHTML = "";

});
// ***************************************************************
function retourExemplaireExistant(){
	document.getElementById('exemplaireexistant').addEventListener('click', function() {
		ajouterexemplaireExistant();
	});
}
///*******************************************************
document.getElementById('btnsuprusager').addEventListener('click', function() {
if (document.getElementById('champsuprid').checkValidity()) {
	supprimerUsager(info);
} else {
	alert('Format invalide !');
}
});
document.getElementById('btnrecommencerusager').addEventListener('click', function() {
document.getElementById('reponseSupprimerUsager').innerHTML = "";

});
// document.getElementById('supprimerusager').addEventListener('click', function() {
// if (document.getElementById('idusager').checkValidity()) {
// 	supprimerUsager(info);
// } else {
// 	info('Format invalide !' , 'reponseUsager')
// }
// });
