<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
 
    <title>Upload de arquivos</title>
</head>
<body>
    <div class="container">
    <h1 class="mt-5 text-center">Upload de arquivos</h1>
    <form method="post" enctype="multipart/form-data" class="m-3">
        <div class="input-group">
            <input type="file" class="form-control" name="arquivo[]" multiple id="arquivo" aria-describedby="arquivo" aria-label="Upload" required>
            <button class="btn btn-outline-primary" type="submit" name="enviar" id="enviar">Enviar</button>
        </div>
    </form>
    </div>
<?php 
function reArrayFiles(&$file_post) {

    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}
    if(isset($_POST['enviar'])){
        //Validações
        $arquivo_array = reArrayFiles($_FILES['arquivo']);

        foreach ($arquivo_array as $arquivo) {
            $tamanhoMax = 2097152; // 2MB em bytes
            $permitido = array("jpg", "png", "jpeg", "pdf", "mp4", "avi");
            $extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
            
            //verificar se tem o tamanho permitido
            if ($arquivo['size'] >= $tamanhoMax) {
                echo '<div class="alert alert-danger" role="alert">
                <b>'.$arquivo['name'].' </b> - Erro: Tamanho máximo de 2MB. Upload não realizado!
                </div>';
            } else {
                //verificar se extensão é permitida
                if(in_array($extensao, $permitido)){
                    //echo "Permitido";
                    $pasta = "arquivosMultiplos/";
                    if(!is_dir($pasta)){
                        mkdir($pasta, 0755);
                    }
    
                        $tmp = $arquivo['tmp_name'];
                        $novoNome = uniqid().".$extensao";
    
                        if(move_uploaded_file($tmp,$pasta.$novoNome)){
                            echo '<div class="alert alert-success" role="alert">
                            <b>'.$arquivo['name'].' </b>: Upload realizado com sucesso!
                            </div>';         
                        }else {
                            echo '<div class="alert alert-danger" role="alert">
                            <b>'.$arquivo['name'].' </b> - Erro: Não foi possivel fazer o upload!
                            </div>'; 
                        }
                }else {
                    echo '<div class="alert alert-danger" role="alert">
                        <b>'.$arquivo['name'].' </b> - Erro: a extensão ('.$extensao.') não permitida!
                            </div>'; 
                }
            }
        }
        
    }
?>


<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>