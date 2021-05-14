<?php
    require './lib/phpmailer/includes/PHPMailer.php';
    require './lib/phpmailer/includes/SMTP.php';
    require './lib/phpmailer/includes/Exception.php';
    //call the FPDF library
    require('./lib/fpdf/fpdf.php');

    //Define name spaces
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

	class Controleur_Commande extends BaseControleur {
        
        public function traite(array $params) {
            $data = array();

            //Modèle pour les commandes
            $modeleCommande = new Modele_Commande();

            if(isset($params["action"])) {
				$action = $params["action"]; 
            } else {
                //Commande par défaut
                $action = "affichePanier";
            }

            // Switch en fonction de l'action qui nous est envoyée
            // Ce switch détermine la vue $vue et obtient le modèle $data
            switch($action) {

                /*--------------- Insertion(CREATE) ---------------*/

                case "ajouterCommande":
                    if(isset($_SESSION["utilisateur"])) {
                        $modeleUtilisateur =  new Modele_Utilisateur();
                        $modeleVoiture = new Modele_Voiture();
                        
                        $utilisateur = $modeleUtilisateur -> obtenir_par_pseudonyme($_SESSION["utilisateur"]);
                        $usagerId = $utilisateur['idUtilisateur'];

                        if(isset($params["voitureId"], $params["prixVente"], $params["depot"], $params["expeditionId"],
                            $params["modePaiementNo"])) {

                            $noCommande = $modeleCommande -> ajouterCommande($usagerId);

                            $listeVoitureId = explode(',', $params["voitureId"]);
                            $listePrixVente = explode(',', $params["prixVente"]);
                            $listeDepots = explode(',', $params["depot"]);
                            $listeStatutId = array();
                            $voitures = array();

                            foreach ($listeDepots as $depot) {
                                $depot > 0 ? $listeStatutId[] = 2 : $listeStatutId[] = 1;
                            }

                            for($i = 0; $i < count($listeVoitureId); $i++) {
                                $modeleCommande -> ajouterCommandeVoiture($noCommande, $listeVoitureId[$i], 
                                    $listePrixVente[$i], $listeDepots[$i], $listeStatutId[$i], $params["expeditionId"],
                                    $params["modePaiementNo"]);
                                $voitures[] = $modeleVoiture -> obtenirUneVoiture($listeVoitureId[$i])[0];
                            }

                            $texte = "<h1>Confirmation de la commande</h1>
                                <h2>Commande no $noCommande confirmée.</h2>
                                <h2>Client : " . $utilisateur["prenom"] . " " . $utilisateur["nom"] . "</h2><br>
                                <h2>Commande : </h2><br>";
                            foreach($voitures as $voiture) {
                                $texte .= "<h2>" . $voiture["nomMarque"] . " " . $voiture["nomModele"] . " " . $voiture["anneeId"] . "</h2>
                                    <h2>No de série : " . $voiture["noSerie"] . "</h2><h2>Prix : " . $voiture["prixAchat"] * 1.25 . "$
                                    </h2><br>";
                            }
                                
                            $this -> confirmeCommande($utilisateur['courriel'], $texte);
                        } else {
                            trigger_error("Paramètre manquant.");
                        }
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion"); 
                    }
                    break;

                case "ajouterCommandeEmploye":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        if(isset($params["commandeNo"], $params["usagerId"], $params["voitureId"], 
                            $params["prixVente"], $params["statutId"], $params["expeditionId"], 
                            $params["modePaiementNo"])) {
                            
                            if(!isset($params["depot"])) $params["depot"] = 0;
                            
                            $utilisateur = $modeleCommande -> obtenir_par_id("utilisateur", "idUtilisateur", $params["usagerId"]);
                            $modeleVoiture = new Modele_Voiture();
                            $voiture = $modeleVoiture -> obtenirUneVoiture($params["voitureId"])[0];
                            
                            //Ajout à une commande
                            if($modeleCommande -> obtenir_par_id('commande', 'noCommande', $params["commandeNo"])) {
                                $modeleCommande -> ajouterCommandeVoiture($params["commandeNo"], $params["voitureId"], 
                                    $params["prixVente"], $params["depot"], $params["statutId"], 
                                    $params["expeditionId"], $params["modePaiementNo"]);
                                
                                $texte = "<h1>Confirmation d'ajout à la commande</h1>
                                    <h2>Ajout à la commande no " . $params["commandeNo"] . "</h2>
                                    <h2>Client : " . $utilisateur["prenom"] . " " . $utilisateur["nom"] . "</h2><br>
                                    <h2>Commande : </h2><br><h2>" . $voiture["nomMarque"] . " " . $voiture["nomModele"] . " " . $voiture["anneeId"] . "</h2>
                                    <h2>No de série : " . $voiture["noSerie"] . "</h2><h2>Prix : " . $voiture["prixAchat"] * 1.25 . "$
                                    </h2><br>";
                            //Nouvelle commande
                            } else {
                                $commandeId = $modeleCommande -> ajouterCommande($params["usagerId"]);
                                $modeleCommande -> ajouterCommandeVoiture($commandeId, $params["voitureId"], 
                                $params["prixVente"], $params["depot"], $params["statutId"], 
                                $params["expeditionId"], $params["modePaiementNo"]);

                                $texte = "<h1>Confirmation de la commande</h1>
                                    <h2>Commande no $commandeId confirmée.</h2>
                                    <h2>Client : " . $utilisateur["prenom"] . " " . $utilisateur["nom"] . "</h2><br>
                                    <h2>Commande : </h2><br><h2>" . $voiture["nomMarque"] . " " . $voiture["nomModele"] . " " . $voiture["anneeId"] . "</h2>
                                    <h2>No de série : " . $voiture["noSerie"] . "</h2><h2>Prix : " . $voiture["prixAchat"] * 1.25 . "$
                                    </h2><br>";
                            }
                                
                            $this -> confirmeCommande($utilisateur['courriel'], $texte);
                            
                        } else {
                            trigger_error("Paramètre manquant.");
                        }
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion"); 
                    }
                    break;

                case "ajouterFacture":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        if(isset($params["noFacture"], $params["prixFinal"])) {
                            
                            if($modeleCommande -> obtenir_par_id('facture', 'noFacture', $params["noFacture"])) {
                                $modeleCommande -> modifierFacture($params["noFacture"], $params["prixFinal"]);
                                
                            } else {
                                $modeleCommande -> ajouterFacture($params["noFacture"], $params["prixFinal"]);
                            }

                            $data = $modeleCommande -> obtenirFacture($params["noFacture"]);
                            
                            $this -> envoieFacture($data, $params["noFacture"], $params["prixFinal"]);
                        } else {
                            trigger_error("Paramètre manquant.");
                        }
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion"); 
                    }
                    break;
                case "ajouterModePaiement":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        if(isset($params["nomModeFR"], $params["nomModeEN"])) {
                            $modeleCommande -> ajouterModePaiement($params["nomModeFR"], $params["nomModeEN"]);
                            $data["modePaiement"] = $modeleCommande -> obtenir_tous('modePaiement');

                            //$this -> afficheVue("ListeModePaiement", $data);
                        } else {
                            trigger_error("Paramètre manquant.");
                        }
                    }
                    break;

                /*--------------- Lecture(READ) ---------------*/
                
                case "affichePanier":
                    if(isset($_SESSION["utilisateur"])) {
                        $modeleUtilisateur =  new Modele_Utilisateur();
                        $usagerId = $modeleUtilisateur -> obtenir_par_pseudonyme($_SESSION["utilisateur"])['idUtilisateur'];
                        $data["taxes"] = $modeleUtilisateur -> obtenir_taxe_utilisateur($usagerId);
                        $data["modePaiement"] = $modeleCommande -> obtenir_tous("modePaiement");
                        $data["expeditions"] = $modeleCommande -> obtenir_tous("expedition");
                      
                        $this -> afficheVue("Head");
                        $this -> afficheVue("Header");
                        $this -> afficheVue("Panier", $data);
                        $this -> afficheVue("Footer");
                    } else {
                        $data["villes"] = $modeleCommande -> obtenir_tous('ville');
                        $this -> afficheVue("Head");
                        $this -> afficheVue("Header");
                        $this -> afficheVue("Panier", $data);
                        $this -> afficheVue("Footer");
                    }
                    break;

                case "listeCommandes":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        $data["commandes"] = $modeleCommande -> obtenirCommandes();
                        $data["commande"] = $modeleCommande -> obtenir_tous("commande");
                        $data["statuts"] = $modeleCommande -> obtenir_tous("statut");
                        $data["modePaiement"] = $modeleCommande -> obtenir_tous("modePaiement");
                        $data["expeditions"] = $modeleCommande -> obtenir_tous("expedition");
                        $data["utilisateurs"] = $modeleCommande -> obtenir_tous("utilisateur");
                        $data["voitures"] = $modeleCommande -> obtenir_tous("voiture");

                        $this -> afficheVue("Head");
                        $this -> afficheVue("Header");
                        $this -> afficheVue("ListeCommandesAdmin", $data);
                        $this -> afficheVue("Footer");
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;    

                case "listeCommandesAJAX":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        $data["commandes"] = $modeleCommande -> obtenirCommandes();
                        $data["commande"] = $modeleCommande -> obtenir_tous("commande");
                        $data["statuts"] = $modeleCommande -> obtenir_tous("statut");
                        $data["modePaiement"] = $modeleCommande -> obtenir_tous("modePaiement");
                        $data["expeditions"] = $modeleCommande -> obtenir_tous("expedition");
                        $data["utilisateurs"] = $modeleCommande -> obtenir_tous("utilisateur");
                        $data["voitures"] = $modeleCommande -> obtenir_tous("voiture");
                        
                        echo json_encode($data);
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;

                case "afficheCommande":
                    //Affiche une commande spécifique
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        if (isset($params["commandeNo"])) {
                            $data["commande"] = $modeleCommande -> obtenirCommande($params["commandeNo"]);
                            
                            echo json_encode($data);
                        } else {													
                            trigger_error("Paramètre manquant.");
                        }
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;

                case "listeFactures":
                    //Affiche toutes les factures
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        $data["factures"] = $modeleCommande -> obtenirFactures();
                        $data["commandes"] = $modeleCommande -> obtenirCommandesFacturees();
                        
                        $this -> afficheVue("Head");
                        $this -> afficheVue("Header");
                        $this -> afficheVue("ListeFacturesAdmin", $data);
                        $this -> afficheVue("Footer");
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;    

                case "listeFacturesAJAX":
                    //Affiche toutes les factures
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        //$vue = "ListeFactures";
                        $data["factures"] = $modeleCommande -> obtenirFactures();
                        $data["commandes"] = $modeleCommande -> obtenirCommandesFacturees();
                    
                        echo json_encode($data);
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;

                case "afficheFactureAJAX":
                    //Affiche une facture donnée
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        if (isset($params["noFacture"])) {
                            //Affiche une Facture d'une commande donnée
                            //$vue = "Facture";
                            $data["facture"] = $modeleCommande -> obtenirFacture($params["noFacture"]);

                            echo json_encode($data);
                        } else {													
                            trigger_error("Paramètre manquant.");
                        }
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;

                case "afficheModePaiement":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        if(isset($params["idModePaiement"])) {
                            $data["modePaiement"] = $modeleCommande -> obtenir_par_id('modePaiement', 'idModePaiement', $params["idModePaiement"]);

                            $this -> afficheVue("Head");
                            $this -> afficheVue("Header");
                            $this -> afficheVue("ListeModePaiement", $data);
                            $this -> afficheVue("Footer");
                        } else {
                            trigger_error("Paramètre manquant.");
                        }
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;

                case "afficheModePaiementAJAX":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        if(isset($params["idModePaiement"])) {
                            $data["modePaiement"] = $modeleCommande -> obtenir_par_id('modePaiement', 'idModePaiement', $params["idModePaiement"]);

                            echo json_encode($data);
                        } else {
                            trigger_error("Paramètre manquant.");
                        }
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;

                case "listeModePaiement":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        $data["modePaiement"] = $modeleCommande -> obtenir_tous("modePaiement");

                        $this -> afficheVue("Head");
                        $this -> afficheVue("Header");
                        $this -> afficheVue("ListeModePaiement", $data);
                        $this -> afficheVue("Footer");
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;

                case "listeModePaiementAJAX":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        $data["modePaiement"] = $modeleCommande -> obtenir_tous("modePaiement");

                        echo json_encode($data);
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;

                /*--------------- Modification(UPDATE) ---------------*/

                case "modifierCommande":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        if(isset($params["commandeNo"], $params["usagerId"], $params["voitureId"], 
                            $params["prixVente"], $params["statutId"], $params["expeditionId"], 
                            $params["modePaiementNo"])) {

                            if(!isset($params["depot"])) $params["depot"] = 0;
                            
                            $modeleCommande -> modifierCommande($params["usagerId"], $params["commandeNo"]);
                            $modeleCommande -> modifierCommandeVoiture($params["commandeNo"], $params["voitureId"], 
                                $params["prixVente"], $params["depot"], $params["statutId"], $params["expeditionId"], 
                                $params["modePaiementNo"]);
                        } else {
                            trigger_error("Paramètre manquant.");
                        }
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;

                case "modifierFacture":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        if(isset($params["noFacture"], $params["prixFinal"])) {
                            
                            $modeleCommande -> modifierFacture($params["noFacture"], $params["prixFinal"]);
                        } else {
                            trigger_error("Paramètre manquant.");
                        }
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;
                    
                case "modifierModePaiement":
                    if (isset($_SESSION["employe"]) || isset($_SESSION["admin"])) {
                        if(isset($params["nomModeFR"], $params["nomModeEN"], $params["idModePaiement"])) {
                            $modeleCommande -> modifierModePaiement($params["nomModeFR"], $params["nomModeEN"], $params["idModePaiement"]);
                        } else {
                            trigger_error("Paramètre manquant.");
                        }
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;
                
                /*--------------- "Suppression" (DELETE) ---------------*/
                case "suppressionCommande":
                    if(isset($_SESSION["admin"])) {
                        if (isset($params["commandeNo"], $params["voitureId"])) {
                            $modeleCommande -> supprimerCommandeVoiture($params["commandeNo"], $params["voitureId"]);
                        } else {
                            trigger_error("Paramètre manquant.");
                        }    
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
                    break;

                case "suppression":
                    //Suppression d'un élément dans n'importe quelle table avec AJAX
                    if(isset($_SESSION["admin"])) {
                        if (isset($params["nomTable"]) && isset($params["id"])) {
                            $nomId = $modeleCommande -> obtenir_nom_id($params["nomTable"]);
                            $modeleCommande -> supprime($params["nomTable"], $nomId, $params["id"]);
                        } else {
                            trigger_error("Paramètre manquant.");
                        }
                    } else {
                        //Redirection vers le formulaire d'authentification
                        header("Location: index.php?Utilisateur&action=connexion");
                    }
					break;
                default:
                    $this -> afficheVue("Head");
                    $this -> afficheVue("Header");
                    $this -> afficheVue("Page404");
                    $this -> afficheVue("Footer");
            }
        }

        public function confirmeCommande($courriel, $texte) {
            
            //Create instance of phpmailer
            $mail = new PHPMailer();

            //Set mailer to use smtp
            $mail -> isSMTP();
            //Define smtp host
            $mail -> Host = "smtp.gmail.com";
            //Enable smtp authentification
            $mail -> SMTPAuth = "true";
            //Set type of encryption (ssl/tls)
            $mail -> SMTPSecure = "tls";
            //Set port to connect smtp
            $mail -> Port = "587";
            //Set gmail username
            $mail -> Username = "yvma.pw2@gmail.com";
            //Set gmail password
            $mail -> Password = "e2095087";
            //Set e-mail subject
            $mail -> Subject = "Confirmation de votre commande";
            //Set sender email
            $mail -> setFrom("yvma.pw2@gmail.com");
            //Enable HTML
            $mail -> isHTML(true);
            //E-mail body
            $mail -> Body = $texte;   
            //Add recipient
            $mail -> AddAddress($courriel);
            //Finally send e-mail
            $mail -> Send();
            //Closing smtp connection
            $mail -> smtpClose();
        }

        public function envoieFacture($data, $noFacture, $prixFinal) {
            $lien = "./lib/phpmailer/attachments/" . $noFacture . ".pdf";
            $courriel = $data["courriel"];
            $nom = $data["nom"];
            $prenom = $data["prenom"];
            $adresse = $data["adresse"];
            $codePostal = $data["codePostal"];
            $telephone = $data["telephone"];
            $identifiant = $data["pseudonyme"];
            $date = date('d-m-Y', strtotime($data["dateFacture"]));
            $noSerie = $data["voitureId"];
            $ville = $data["nomVilleFR"];
            $province = $data["nomProvinceFR"];
            $taxe = $data["nomTaxeFR"];
            $taux = $data["taux"];
            $prixVente = $data["prixVente"];

            //Créer un objet pdf
            $pdf = new FPDF('P','mm','A4');
            //Ajouter une nouvelle page
            $pdf->AddPage();
            //Police arial, bold, 14pt
            $pdf->SetFont('Arial','B',14);

            //Cell(width , height , text , border , end line , [align] )

            $pdf->Cell(130 ,5,'YVMA',0,0);
            $pdf->Cell(59 ,5,'Facture',0,1);//Fin de ligne

            //Police arial, regular, 12pt
            $pdf->SetFont('Arial','',12);

            $pdf->Cell(130 ,5,'9655 rue Docteur Penfield',0,0);
            $pdf->Cell(59 ,5,'',0,1);//Fin de ligne

            $pdf->Cell(130 ,5,'Montréal, Québec, G1T H0B',0,0);
            $pdf->Cell(25 ,5,'Date',0,0);
            $pdf->Cell(34 ,5,$date,0,1);//Fin de ligne

            $pdf->Cell(130 ,5,'Téléphone: 514-555-8978',0,0);
            $pdf->Cell(25 ,5,'Facture #',0,0);
            $pdf->Cell(34 ,5,$noFacture,0,1);//Fin de ligne

            $pdf->Cell(130 ,5,'Fax: 514-555-1454',0,0);
            $pdf->Cell(25 ,5,'Indentifiant',0,0);
            $pdf->Cell(34 ,5,$identifiant,0,1);//Fin de ligne

            //make a dummy empty cell as a vertical spacer
            $pdf->Cell(189 ,10,'',0,1);//Fin de ligne

            //Adresse de facturation
            $pdf->Cell(100 ,5,'Facturé à',0,1);//Fin de ligne

            //add dummy cell at beginning of each line for indentation
            $pdf->Cell(10 ,5,'',0,0);
            $pdf->Cell(90 ,5,$nom . ', '. $prenom,0,1);

            $pdf->Cell(10 ,5,'',0,0);
            $pdf->Cell(90 ,5,$adresse,0,1);

            $pdf->Cell(10 ,5,'',0,0);
            $pdf->Cell(90 ,5,$ville . ', ' . $province . ', ' . $codePostal,0,1);

            $pdf->Cell(10 ,5,'',0,0);
            $pdf->Cell(90 ,5,$telephone,0,1);

            //make a dummy empty cell as a vertical spacer
            $pdf->Cell(189 ,10,'',0,1);//Fin de ligne

            //Contenu de la facture
            $pdf->SetFont('Arial','B',12);

            $pdf->Cell(130 ,5,'No de série',1,0);
            $pdf->Cell(25 ,5,'Taxable',1,0);
            $pdf->Cell(34 ,5,'Montant',1,1);//Fin de ligne

            $pdf->SetFont('Arial','',12);

            //Numbers are right-aligned so we give 'R' after new line parameter

            $pdf->Cell(130 ,5,$noSerie,1,0);
            $pdf->Cell(25 ,5,'-',1,0);
            $pdf->Cell(34 ,5,$prixVente,1,1,'R');//Fin de ligne

            //Sommaire
            $pdf->Cell(130,5,'',0,0);
            $pdf->Cell(25,5,'Sous-total',0,0);
            $pdf->Cell(4,5,'$',1,0);
            $pdf->Cell(30,5,$prixVente,1,1,'R');//Fin de ligne

            $pdf->Cell(130,5,'',0,0);
            $pdf->Cell(25,5,'Taxable',0,0);
            $pdf->Cell(4,5,'$',1,0);
            $pdf->Cell(30,5,'0',1,1,'R');//Fin de ligne

            $pdf->Cell(130,5,'',0,0);
            $pdf->Cell(25,5,$taxe,0,0);
            $pdf->Cell(4,5,'$',1,0);
            $pdf->Cell(30,5,$taux . '%',1,1,'R');//Fin de ligne

            $pdf->Cell(130,5,'',0,0);
            $pdf->Cell(25,5,'Total',0,0);
            $pdf->Cell(4,5, '$' ,1,0);
            $pdf->Cell(30,5,$prixFinal + ($prixFinal * $taux / 100),1,1,'R');//Fin de ligne

            //Sortir le résultat
            $pdf->Output(F, $lien);

            //Create instance of phpmailer
            $mail = new PHPMailer();

            //Set mailer to use smtp
            $mail -> isSMTP();
            //Define smtp host
            $mail -> Host = "smtp.gmail.com";
            //Enable smtp authentification
            $mail -> SMTPAuth = "true";
            //Set type of encryption (ssl/tls)
            $mail -> SMTPSecure = "tls";
            //Set port to connect smtp
            $mail -> Port = "587";
            //Set gmail username
            $mail -> Username = "yvma.pw2@gmail.com";
            //Set gmail password
            $mail -> Password = "e2095087";
            //Set e-mail subject
            $mail -> Subject = "Facture";
            //Set sender email
            $mail -> setFrom("yvma.pw2@gmail.com");
            //Enable HTML
            $mail -> isHTML(true);
            //Attachments
            $mail -> addAttachment("./lib/phpmailer/attachments/" . $noFacture . ".pdf");
            //E-mail body
            $mail -> Body = '<p>Facture en pièce jointe.</p>';   
            //Add recipient
            $mail -> AddAddress($courriel);
            //Finally send e-mail
            $mail -> Send();
            //Closing smtp connection
            $mail -> smtpClose();
        }
    }
?>