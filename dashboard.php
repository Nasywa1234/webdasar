<?php
session_start();
if (!isset($_SESSION['username'])) {
    // User is already logged in, redirect to welcome page  
    header("Location: login.php");

}

if(!isset($_SESSION["counter"])){
    $_SESSION["counter"] = 1;
} else {
    $_SESSION["counter"]++;
}

if(!isset($_SESSION["daftar"])){
    $_SESSION["daftar"] = [];
}

if (isset($_POST["namaku"]) && isset($_POST["umurku"])) {
    $nama = trim($_POST["namaku"]);
    $umur = intval($_POST["umurku"]); 

    if ($nama !== "" && $umur > 0) {
        $daftar = [
            'nama' => $nama,
            'umur' => $umur,
        ];
        $_SESSION["daftar"][] = $daftar;
    }
}

$edit_daftar = [
    'nama' => "",
    'umur' => "",
];

$target = "dashboard.php";
if(isset($_GET["kunci"])){
    $target = "ubah.php?kunci=" .$_GET["kunci"];
    if($_GET["kunci"] != null){
        $i = $_GET["kunci"];
        $edit_daftar = $_SESSION["daftar"][$i];
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>::Login Page::</title>
        <style type="text/css">
            body{
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                height: 100vh;
                background-size: cover;
                background-image: url("https://cdn.arstechnica.net/wp-content/uploads/2023/06/bliss-update-1440x960.jpg");
            }
            table{
                background-color: white;
                border: 3px solid grey;
                padding: 20px;
                border-radius: 10px;
                font-family:Arial, Helvetica, sans-serif;
            }
            td{
                padding: 5px;
            }
            button{
                background-color: greenyellow;
                padding: 10px;
                border-radius: 5px;
            }
            #logout{
                background-color: red;
            }

        </style>
            <title>Dashboard</title>

    </head>
    <body>
        <h1><?php echo "Selamat datang " . $_SESSION['username'] . " ke-" . $_SESSION["counter"]  ?></h1>
        <br>
        <form action="<?php echo $target; ?>" method="post">
         <table>
            <tr>
                <td colspan="2" style="text-align: center;" >DAFTAR</td>
            </tr>
            <tr>
                <td>Nama</td>
                <td><input type="text" name="namaku" value="<?php echo $edit_daftar["nama"] ?>" /></td>
            </tr>
            <tr>
                <td>Umur</td>
                <td><input type="number" name="umurku" min="1" value="<?php echo $edit_daftar["umur"] ?>" /></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <button type="submit" >PROSES</button>
                    <a href="logout.php">
                        <button id="logout" type="button" >LOGOUT</button>
                    </a>
                </td>
            </tr>
        </table>
        <table border="1">
            <tr>
                <td>Nama</td>
                <td>Umur</td>
                <td>keterangan</td>
                <td>Aksi</td>
            </tr>
            <?php foreach($_SESSION["daftar"] as $i => $daftar_item): ?>
            <tr>
                <td><?php echo $daftar_item ["nama"]; ?></td>
                <td><?php echo $daftar_item ["umur"]; ?></td>
                <td>
                    <?php
                        $umur = $daftar_item["umur"];
                        if ($umur < 10) {
                            echo "Anak";
                        }elseif ($umur < 20){
                            echo "Remaja";
                        }elseif ($umur < 40){
                            echo "Dewasa";
                        }elseif ($umur < 80){
                            echo "Tua";
                        }elseif ($umur < 100){
                            echo "sudah dipanggil allah";
                        }else{
                            echo "tidak diketahui";
                        }
                ?>
                </td>
                <td><a href="hapus.php?id=<?php echo $i; ?>" onclick="return confirm('Yakin ingin menghapus data ini?')">hapus</a>
                    <a href="dashboard.php?kunci=<?php echo $i; ?>">ubah</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        </form>
    </body>
</html>