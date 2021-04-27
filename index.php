<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css"/>
	</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<a class="navbar-brand" href="https://diji+.com">Diji+ | Veri ve Analiz Çözümleri</a>
		</div>
	</nav>
	<div class="col-md-3"></div>	
	<div class="col-md-6 well">
		<h3 class="text-primary">Dosyalarınız</h3>
		<hr style="border-top:1px dotted #ccc;"/>
		<center>
			<form method="POST" action="upload.php" enctype="multipart/form-data">
				<div class="form-inline">
					<input type="file" class="form-control" name="file" required="required"/>
					<button class="btn btn-primary" name="upload"><span class="glyphicon glyphicon-upload"></span> Yükle</button>
				</div>
			</form>
		</center>
		<br />
		<table class="table table-bordered">
			<thead class="alert-info">
				<tr>
					<th>Dosya</th>
					<th>İşlem</th>
				</tr>
			</thead>
			<tbody>
				<?php
					require '../ortak/baglanti.php';
					$query = $baglanti->prepare("SELECT * FROM `file`");
					$query->execute();
					while($fetch = $query->fetch()){
				?>
				<tr>
					<td><?php echo $fetch['file']?></td>
					<td>
                        <div class="d-flex justify-content-center">
                            <div class="d-flex justify-content-center">
                                <form action="download.php?file_id=<?php echo $fetch['file_id']?>" method="POST">
                                    <input type="hidden" name="file_id" value="<?php echo $fetch['file_id'] ?>">
                                    <button type="submit" name="dosya_indir" class="btn btn-success btn-sm btn-icon-split">
                                      <span class="icon text-white-60">
                                        <i class="fas fa-edit"></i>
                                      </span>
                                    </button>
                                </form>
                                <form class="mx-1" action="islemler/islem.php" method="POST">
                                    <input type="hidden" name="file_id" value="<?php echo $fetch['file_id'] ?>">
                                    <button type="submit" name="dosya_sil" class="btn btn-danger btn-sm btn-icon-split">
                                      <span class="icon text-white-60">
                                        <i class="fas fa-trash"></i>
                                      </span>
                                    </button>
                                </form>
                                <form action="dosya.php?file_id=<?php echo $fetch['file_id']?>" method="POST">
                                    <input type="hidden" name="file_id" value="<?php echo $fetch['file_id'] ?>">
                                    <button type="submit" name="dosya_bak" class="btn btn-primary btn-sm btn-icon-split">
                                        <span class="icon text-white-60">
                                          <i class="fas fa-eye"></i>
                                        </span>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </td>
				</tr>
				<?php
					}
				?>
			</tbody>
		</table>
	</div>
</body>	
</html>