<!-- Bootstrap 5 structure -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card d-flex">
                <div class="card-content m-3">
                    <div class="row">
                        <div class="col-6">
                            <form action="" method="post">
                                <div class="mb-3">
                                    <label for="jgrowl" class="form-label">jGrowl</label>
                                    <input type="text" class="form-control" id="jgrowl" name="jgrowl">
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-danger" name="submit" value="error">Error</button>
                                    <button type="submit" class="btn btn-warning" name="submit" value="warning">Warning</button>
                                    <button type="submit" class="btn btn-info" name="submit" value="info">Info</button>
                                    <button type="submit" class="btn btn-success" name="submit" value="success">Success</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-6">
                            <div class="col-6">
                                <?php
                                if (isset($_POST['submit'])) {

                                    $input_str = $_POST['jgrowl'];

                                    // Regular expression to extract message and header from jGrowl string
                                    $regex = '/\$.jGrowl\("(.+)"\s*,\s*\{\s*(?:header:\s*\'(.+)\',?\s*)?(?:sticky:\s*(true|false)\s*)?\}\s*\);/';
                                    switch($_POST['submit']){
                                        case 'error':
                                            $type = 'error';
                                            break;
                                        case 'warning':
                                            $type = 'warning';
                                            break;
                                        case 'info':
                                            $type = 'info';
                                            break;
                                        case 'success':
                                            $type = 'success';
                                            break;
                                        default:
                                            $type = 'success';
                                            break;
                                    }
                                    // Extract message and header using regex
                                    if (preg_match($regex, $input_str, $matches)) {
                                        // Construct SweetAlert initialization code using extracted message and header
                                        $output_str = "swalInit.fire({text: '".htmlspecialchars($matches[1])."', icon: '{$type}', toast: true, showConfirmButton: false, position: 'top-end', timer: 3000";

                                        // Add header option if present
                                        if (!empty($matches[2])) {
                                            $output_str .= ", title: '".htmlspecialchars($matches[2])."'";
                                        }

                                        // Add sticky option if present
                                        if (!empty($matches[3])) {
                                            $output_str .= ", timer: " . ($matches[3] === 'true' ? 'true' : 'false');
                                        }
                                        $output_str .= "});";
                                    } else {
                                        $output_str = "Error!";
                                    }
                                }

                                if (isset($output_str) && $output_str != 'Error!') { ?>
                                    <div class="mb-3">
                                        <label for="myTextArea" class="form-label">Output</label>
                                        <textarea id="myTextArea" class="form-control" rows="10" readonly><?= $output_str ?></textarea>
                                    </div>
                                    <button type="button" class="btn btn-primary" onclick="copyToClipboard()">Copy to clipboard</button>
                                    <script>
                                        function copyToClipboard() {
                                            // Get the text area
                                            var textArea = document.getElementById("myTextArea");

                                            // Select the text area content
                                            textArea.select();

                                            // Copy the selected text to the clipboard
                                            document.execCommand("copy");
                                        }
                                    </script>
                                <?php } else {
                                    echo ("Error!");
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
