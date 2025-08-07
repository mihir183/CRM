<?php include 'check_session.php' ?>
<?php
include 'db.php';

if ($conn) {
    $stmt = $conn->prepare("SELECT * FROM client");
    $stmt->execute();
    $result = $stmt->get_result();
    $clients = [];
    while ($row = $result->fetch_assoc()) {
        $clients[] = $row;
    }
    $stmt->close();
}

?>
<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap demo</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    </head>

    <body>
        <?php include 'header.php' ?>

        <div class="container mt-5 d-flex justify-content-between">
            <h4 class="text-primary text-capitalize text-start"><i class="fa-solid fa-ticket"></i> add ticket register
            </h4>
            <a href="ticket_register.php" class="">
                <button class="btn btn-primary text-right">
                    < back</button>
            </a>
        </div>

        <div class="container mt-3">
            <p class="text-danger">* Denotes compulsory fields & special symbol like <> " ' \ etc is not alow due to
                    security reason</p>

            <form action="" method="post">
                <div class="row row-cols-2">
                    <div class="col">
                        <label for="date" class="text-capitalize form-label">date<span
                                class="text-danger">*</span></label>
                        <input type="date" id="date" name="date" required class="form-control mb-2">

                        <label for="client" class="text-capitalize form-label">client<span
                                class="text-danger">*</span></label>
                        <select name="client" id="client" class="form-control mb-5">
                            <!-- Fetch Client Name for select client Ticket registration -->
                            <?php if (count($clients) > 0): ?>
                                <?php foreach ($clients as $index => $client): ?>
                                    <option value="<?= htmlspecialchars($client['key_person']) ?>" class="text-capitalize">
                                        <?= htmlspecialchars($client['key_person']) ?>
                                    </option>

                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="" class="text-capitalize">Select Client</option>
                            <?php endif; ?>

                        </select>

                        <label for="product" class="text-capitalize form-label">product<span
                                class="text-danger">*</span></label>
                        <select name="product" id="" class="form-control">
                            <option value="" class="text-capitalize">Select product</option>
                        </select>

                        <label for="complain" class="text-capitalize form-label">complain<span
                                class="text-danger">*</span></label>
                        <textarea name="complain" id="complain" name="complain" class="form-control">
                        </textarea>
                    </div>
                    <!-- Column 2 -->
                    <div class="col">
                        <div class="row row-cols-2 mb-1">
                            <div class="col">
                                <label for="name" class="text-capitalize form-label">name</label>
                                <input type="text" id="name" name="name" required class="form-control mb-2">
                            </div>
                            <div class="col">
                                <label for="mobile" class="text-capitalize form-label">registered mobile</label>
                                <input type="text" id="mobile" name="mobile" required class="form-control mb-2">
                            </div>
                        </div>

                        <div class="address mb-1">
                            <label for="address" class="text-capitalize form-label">address</label>
                            <textarea name="address" id="address" class="form-control">
                            </textarea>
                        </div>

                        <div class="row row-cols-2 mb-1">
                            <div class="col">
                                <label for="city" class="text-capitalize form-label">city</label>
                                <input type="text" id="city" name="city" class="form-control mb-2" required>
                            </div>
                            <div class="col">
                                <label for="email" class="text-capitalize form-label">email address</label>
                                <input type="text" id="email" name="email" class="form-control mb-2" required>
                            </div>
                        </div>

                        <div>
                            <label for="exdate" class="text-capitalize form-label">expired date</label>
                            <input type="text" id="exdate" name="exdate" class="form-control mb-2" required
                                placeholder="Expired Date">
                        </div>

                        <div class="row row-cols-2 mb-1">
                            <div class="col">
                                <label for="ctype" class="text-capitalize form-label">call type</label>
                                <input type="text" id="ctype" name="ctype" class="form-control mb-2" required>
                            </div>
                            <div class="col">
                                <label for="serial" class="text-capitalize form-label">serial number</label>
                                <input type="text" id="serial" name="serial" class="form-control mb-2" required>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="mb-3">
                    <label for="remark" class="text-capitalize">special remark</label>
                    <input type="text" class=form-control>
                </div>

                <div class="row row-cols-3 mb-4">
                    <div class="col">
                        <label class="form-label text-capitalize">select image1</label>
                        <input type="file" name="img1" id="img1">
                    </div>
                    <div class="col">
                        <label class="form-label text-capitalize">select image2</label>
                        <input type="file" name="img2" id="img2">
                    </div>
                    <div class="col">
                        <label class="form-label text-capitalize">select image3</label>
                        <input type="file" name="img3" id="img3">
                    </div>
                </div>

                <div class="row row-cols-2 mb-4">
                    <div class="col">
                        <label for="given" class="form-label text-capitalize">given by<span
                                class="text-danger">*</span></label>
                        <input type="text" name="given" id="given" class="form-control">
                    </div>
                    <div class="col">
                        <label for="number" class="form-label text-capitalize">mobile number<span
                                class="text-danger">*</span></label>
                        <input type="text" name="number" id="number" class="form-control">
                    </div>
                </div>

            </form>
        </div>

        <?php include 'footer.php' ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
            crossorigin="anonymous"></script>
    </body>

</html>