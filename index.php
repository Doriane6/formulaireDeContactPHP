<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de contact</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bungee+Spice&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bungee+Spice&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<div class="code_php">
    <?php
    $nom = $prenom = $sexe = $email = $message = "";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom = $_POST['nom'] ?? '';
        $prenom = $_POST['prenom'] ?? '';
        $sexe = $_POST['sexe'] ?? '';
        $email = $_POST['email'] ?? '';
        $message = $_POST['message'] ?? '';
        $erreurs = [];
        $message_de_succes = "Félicitations ! Votre message a bien été enregistré";
         $message_general_erreur = "";
    function verification($valeur_label, $label)
    {
        global $message_general_erreur;
        global $erreurs;
        $valeur_label = htmlspecialchars($valeur_label, ENT_QUOTES, 'UTF-8');
        if (empty($valeur_label)) {
            $erreurs[$label] = '*Ce champ est obligatoire';
            $message_general_erreur = "Veuillez corriger les erreurs !";
            return;
        }
        if ($label == 'Email') {
            if (!filter_var($valeur_label, FILTER_VALIDATE_EMAIL)) {
                $erreurs[$label] = "*Email invalide<br>";
                $message_general_erreur = "Veuillez corriger les erreurs !.";
            }
        } elseif ($label != 'Message') {
            // Validation pour les autres champs (Nom, Prénom, Sexe...)
            if (strlen($valeur_label) < 2) {
                $erreurs[$label] = "*$label invalide<br>";
                $message_general_erreur = "Veuillez corriger les erreurs !.";
            } elseif (!preg_match("/^[A-Za-zÀ-ÿ\s'-]+$/u", $valeur_label)) {
                $erreurs[$label] = "*$label invalide<br>";
                $message_general_erreur = "Veuillez corriger les erreurs !.";
            }
        }
    }
    verification($nom, 'Nom');
    verification($prenom, 'Prenom');
    verification($sexe, 'Sexe');
    verification($email, 'Email');
    verification($message, 'Message');
    if (empty($message_general_erreur)) {

        $donnees = array(
            'nom' => $nom,
            'prenom' => $prenom,
            'sexe' => $sexe,
            'email' => $email,
            'message' => $message
        );
        $fichier = 'infos.json';
        if (!file_exists($fichier)) {
            file_put_contents($fichier, json_encode([]));
        }
        $contenu = file_get_contents($fichier);
        $tableau = json_decode($contenu, true);
        if (!is_array($tableau)) {
            $tableau = [];
        }
        $tableau[] = $donnees;
        file_put_contents($fichier, json_encode($tableau, JSON_PRETTY_PRINT));

    }
    
    }
    
    ?>

    <body>
        <div class="conteneur">
            <div class="titre">
                <h2>Formulaire de contact</h2>
                <div class="erreur" id="erreur_generale">
                    <?php if (!empty($message_general_erreur)) { ?>
                        <p style="color:red; font-weight:bold; font-family: 'Poppins', sans-serif;"><?= $message_general_erreur ?></p>
                    <?php } elseif (isset($message_de_succes)) {
                        echo "<p style=' color:green; font-weight:bold;font-family: 'Poppins', sans-serif;font-size:10px;' >" . $message_de_succes . "</p> ";
                    };
                    ?>
                </div>

            </div>
            <div class="formulaire">
                <form action="" method="POST">
                    <div class="divnom" id="group">
                        <label for="inputname">Nom :</label>
                        <input type="text" id="inputname" name="nom">
                        <div class="erreur">
                            <?php
                           
                            if (!empty($erreurs["Nom"])) :
                                echo $erreurs["Nom"];
                            endif;
                            ?>
                        </div>

                    </div>
                    <div class="divprenom" id="group">
                        <label for="inputprenom">Prénoms :</label>
                        <input type="text" id="inputprenom" name="prenom">
                        <div class="erreur">
                            <?php
                      
                            if (!empty($erreurs["Prenom"])) {
                                echo $erreurs["Prenom"];
                            }

                            ?>

                        </div>
                    </div>
                    <div class="divsex" id="group">
                        <label for="inputsex">Sexe : </label>
                        <select name="sexe" id="" value="">
                            <Option value=" " selected disabled hidden></Option>
                            <option value="Masculin" id="inputsex">Masculin</option>
                            <option value="Feminin" id="inputsex">Féminin</option>
                        </select>
                        <div class="erreur">
                            <?php
                          
                            if (!empty($erreurs["Sexe"])) {
                                echo $erreurs["Sexe"];
                            }
                            ?>
                        </div>
                    </div>
                    <div class="divemail" id="group">
                        <label for="inputemail">Email :</label>
                        <input type="email" name="email" id="inputemail">
                        <div class="erreur">
                            <?php

                       
                            if (!empty($erreurs["Email"])) {
                                echo $erreurs["Email"];
                            }
                            ?>
                        </div>
                    </div>
                    <div class="divmessage" id="group">
                        <label for="Message">Message</label>
                        <textarea name="message" id="Message"></textarea>
                        <div class="erreur">
                            <?php
                           
                            if (!empty($erreurs["Message"])) {
                                echo $erreurs["Message"];
                            }
                            ?>
                        </div>
                    </div>
                    <button>ENVOYER</button>
            </div>

            </form>
        </div>
</div>

</body>
<style>
    button {
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 35%;
        padding: 5px 10%;
        background-color: #ff729f;
        color: white;
    }


    form {
        margin: auto;
        width: 25%;
        box-shadow: 0 0 10px #ff729f;
        padding: 30px;
        font-family: "Playfair Display";
    }

    h2 {
        text-align: center;
        color: white;
        font-family: "Poppins", sans-serif;
        ;
    }

    .conteneur {
        margin-top: 6em;
        display: grid;
        border: 4px;
        border-radius: 50px;
    }

    .erreur {
        font-size: 15px;
        color: red;
        font-family: "Poppins", sans-serif;
    }

    #erreur_generale {
        text-align: center;
        font-size: 20px;

    }

    body {
        font-size: 20px;
        background-color: #031D44;
        color: white;
    }
</style>

</html>