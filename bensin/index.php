<?php

class Shell {
    public $harga;
    public $jenis;
    public $ppn;

    public function __construct($harga, $jenis, $ppn) {
        $this->harga = $harga;
        $this->jenis = $jenis;
        $this->ppn = $ppn;
    }

    public function getHarga() {
        return $this->harga;
    }

    public function getJenis() {
        return $this->jenis;
    }

    public function getPpn() {
        return $this->ppn;
    }
}

class Beli extends Shell {
    private $jumlah;
    private $totalBayar;
    public $jumlahLiter;

    public function __construct($harga, $jenis, $ppn, $jumlah) {
        parent::__construct($harga, $jenis, $ppn);
        $this->jumlah = $jumlah;
        $this->totalBayar = $this->calculateTotalBayar();
    }

    private function calculateTotalBayar() {
        $hargaPerLiter = $this->getHarga();
        $this->jumlahLiter = $this->jumlah;
        $ppnPercentage = $this->getPpn() / 100;
        $subTotal = $hargaPerLiter * $this->jumlahLiter;
        $ppnAmount = $subTotal * $ppnPercentage;
        $totalBayar = $subTotal + $ppnAmount;
        return $totalBayar;
    }

    public function getTotalBayar() {
        return $this->totalBayar;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jenisBahanBakar = $_POST["tipeBahanBakar"];
    $jumlahLiter = $_POST["jumlahLiter"];

    $harga = 0;
    $ppn = 10;

    switch ($jenisBahanBakar) {
        case "Shell Super":
            $harga = 17310;
            break;
        case "SVPowerDiesel":
            $harga = 18310;
            break;
        case "V-Power":
            $harga = 19310;
            break;
        case "V-Power Nitro":
            $harga = 20310;
            break;
    }

    $beli = new Beli($harga, $jenisBahanBakar, $ppn, $jumlahLiter);
    echo '<div class="container">';
    echo '<div class="row">';
    echo '<div class="col-md-6 offset-md-3">';
    echo '<div class="card">';
    echo '<div class="card-body">';
    echo "<h3>Ringkasan Pembelian</h3>";
    echo "<hr>";
    echo "<p>Anda membeli bahan bakar minyak tipe ". $beli->getJenis(). " dengan jumlah : ". $beli->jumlahLiter. " Liter</p>";
    echo "<p>Total yang harus anda bayar : Rp. ". number_format($beli->getTotalBayar(), 2, '.', ','). "</p>";
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Belanja Bahan Bakar</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="">
                        <div class="form-group">
                            <label for="jumlahLiter">Masukkan Jumlah Liter:</label>
                            <input type="number" id="jumlahLiter" name="jumlahLiter" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="tipeBahanBakar">Pilih Tipe Bahan Bakar:</label>
                            <select id="tipeBahanBakar" name="tipeBahanBakar" class="form-control">
                                <option value="Shell Super">Shell Super</option>
                                <option value="SVPowerDiesel">SVPowerDiesel</option>
                                <option value="V-Power">V-Power</option>
                                <option value="V-Power Nitro">V-Power Nitro</option>
                            </select>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Beli</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
