<?php
include ("../db/config.php");
$banco = new Banco($servername, $username, $password, $dbname);


if (isset($_GET['Validation'])) {
    if (isset($_POST["Ok"]) && !empty($_POST["Name"]) && !empty($_POST["Password"])) {
        $Name = $_POST["Name"];
        $Password = $_POST["Password"];

        print_r("Usuário: " . $Name . "<br>" . "Senha: " . $Password);

        $sql = "SELECT * FROM users WHERE User_name = '$Name' and User_password = '$Password'";
        $result = $banco->select($sql);

        print_r($result->num_rows);

        if ($result->num_rows > 0) {
            header("Location: ?Logado");
        } else {
            header("Location: ?Login");
        }


    } else {
        header("Location: ?Login");
    }
}

if (isset($_GET['Complaint'])) {
    if (isset($_POST["Ok"]) && !empty($_POST["Registration"]) && !empty($_POST["Name"]) && !empty($_POST["Type"]) && !empty($_POST["Description"])) {
        $Registration = $_POST["Registration"];
        $Name = $_POST["Name"];
        $Type = $_POST["Type"];
        $Description = $_POST["Description"];

        print_r("Nome: " . $Name . "<br>" . "Matricula: " . $Registration . "<br>" . "Tipo: " . $Type . "<br>" . "Descrição: " . $Description);

        $sql = "INSERT INTO records (Rec_reg, Rec_nam, Rec_typ, Rec_des)" . " VALUES ($Registration, '$Name', '$Type', '$Description')";
        $banco->SQL($sql);

        header("Location: funcional.php?Reclamacao");

    } else {
        header("Location: funcional.php");
    }
}

if (isset($_GET['Detalhe'])) {
    $Id = $_GET['Detalhe'];
    if (isset($_POST["Ok"]) && !empty($_POST["Id"])) {
        $Id = $_POST["Id"];
    } 
    if (isset($_POST["Exit"])) {
        header("Location: funcional.php");
    }
    $sql = "SELECT * FROM records WHERE Rec_id = $Id";
    $result = $banco->select($sql);
    $result = mysqli_fetch_array($result);
}

if (isset($_GET['Consulta']) && (isset($_GET['Logado']))) {
    header("Location: ?Logado");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/reset_Eric_Mayer.css">
    <link rel="stylesheet" href="../style/style.css">
    <title>Faleconosco</title>
    <style>
        body {
            width: 100vw;
            height: 100vh;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-template-rows: repeat(3, 1fr);
            background: linear-gradient(to bottom, rgb(255, 255, 255), rgb(100, 100, 100));
        }

        #bts {
            z-index: 1;
            grid-column-start: 2;

            grid-column-end: 3;
            background-color: rgba(180, 180, 180, 0.6);
            border-radius: 0 0 10px 10px;
            padding: 10px;
            height: fit-content;
            text-align: center;

            a {
                margin: 0 5px;
            }
        }

        .forms {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
        }

        #result {
            grid-row-start: 2;
            grid-row-end: 3;
            grid-column-start: 2;
            grid-column-end: 3;

            a {
                text-decoration: none;
                color: white;
            }
        }


        .pag {
            width: 100vw;
            height: 100vh;
            position: absolute;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-template-rows: repeat(3, 1fr);
            display: none;

        }

        #pag1 {
            background: linear-gradient(to top, rgb(0, 0, 0), rgb(255, 255, 80));

        }

        #pag2 {
            background: linear-gradient(to top, rgb(0, 0, 0), rgb(255, 100, 80));

        }

        #pag3 {
            background: linear-gradient(to top, rgb(0, 0, 0), rgb(255, 80, 255));

        }

        #pag4 {
            background: linear-gradient(to top, rgb(0, 0, 0), rgb(40, 80, 255));

        }
    </style>
</head>

<body>

    <div id="bts">
        <a href="funcional.php">Home</a>
        <a href="?Reclamacao">Complaint</a>
        <a href="?Login">Login</a>
        <a href="?Consulta">Query</a>
    </div>


    

    <div class="pag" id="pag1" style="display: <?php if (isset($_GET['Reclamacao'])) { echo ("grid"); } ?>;">
        
    <h1>Pagina de reclamação</h1>

        <form class="forms" id="Complaint" name="Complaint" method="post" action=" <?php 
        if (isset($_GET['Detalhe'])) {  
            if (!empty($_GET['Detalhe'])) {
                echo ("?Logado");
            } else {
                echo ("?Consulta");}
            } else {echo ("?Complaint");}?>">
            
            <input type="number" id="Registration" name="Registration" placeholder="Matricula" value="<?php if (isset($_GET['Detalhe'])) { echo ($result["Rec_reg"]); } ?>">
            <input type="text" id="Name" name="Name" placeholder="Nome" value="<?php if (isset($_GET['Detalhe'])) { echo ($result["Rec_nam"]); } ?>">
            <input type="text" id="Type" name="Type" placeholder="Tipo" value="<?php if (isset($_GET['Detalhe'])) { echo ($result["Rec_typ"]); } ?>">
            <input type="text" id="Description" name="Description" placeholder="Descrição" value="<?php if (isset($_GET['Detalhe'])) { echo ($result["Rec_des"]); } ?>">
            <input type="submit" id="Exit" name="Exit" value="Fechar">
            <?php if (!isset($_GET['Detalhe'])) { ?><input type="submit" id="Ok" name="Ok" value="OK"><?php } ?>

        </form>

    </div>

    <div class="pag" id="pag2" style="display: <?php if (isset($_GET['Login'])) { echo ("grid"); } ?>;">
        <h1>Pagina de login</h1>

        <form class="forms" id="Login" name="Login" action="?Validation" method="post">
            <input type="text" id="Name" name="Name" placeholder="Nome">
            <input type="text" id="Password" name="Password" placeholder="Senha">
            <input type="submit" id="Exit" name="Exit" value="Fechar">
            <input type="submit" id="Ok" name="Ok" value="OK">
        </form>

    </div>

    <div class="pag" id="pag3" style="display: <?php if (isset($_GET['Consulta'])) { echo ("grid"); } ?>;">
        <h1>Pagina de consulta</h1>

        <form class="forms" id="Query" name="Query" action="?Reclamacao&Detalhe" method="post">
            <input type="number" id="Id" name="Id" placeholder="Id">
            <input type="submit" id="Exit" name="Exit" value="Fechar">
            <input type="submit" id="Ok" name="Ok" value="OK">
        </form>

    </div>

    <div class="pag" id="pag4" style="display: <?php if (isset($_GET['Logado'])) { echo ("grid"); } ?>;">
        <h1>Pagina do adm</h1>

        <div id="result">

            <?php
            while ($row = mysqli_fetch_array($result)) { ?>
                <a href="?Reclamacao&Detalhe=<?php echo ($row["Rec_id"]); ?>"><?php echo ("Nome:" . $row["Rec_nam"]); ?></a><br>
            <?php } ?>

        </div>

    </div>

</body>

</html>