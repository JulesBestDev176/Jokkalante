<?php
  require_once 'dao/connect_bd.php';
  require_once 'dao/fonctions.php';
  $users = $_SESSION['userConnected'];
  $allUsers = getAllUser($users['id']);
  $allPosts = getAllPostInAccueil();
  $allSignal = getAllSignal();

  $numberUser = getNumberUser();
  $numberPost = getNumberPost();
  $numberConnect = getNumberConnection();
  
  $tabUser= getUsersFromTable();
  $tabConn= getConnFromTable();
  $tabPost=getPostFromTable();
  $tabHeure=[];
  $long = tailleTableauPlusLong($tabUser, $tabConn, $tabPost);

  for($i = 0; $i <= $long; $i++){
    $tabHeure[$i] = $i;
  }

  if(isset($_GET['idDelPost'])){
    delPost($_GET['idDelPost']);
    echo "<script>window.location.href = window.location.pathname + '#feed{$_GET['idDelPost']}';</script>";
    exit;
}
if(isset($_GET['idShowPost'])){
  showPost($_GET['idShowPost']);
  echo "<script>window.location.href = window.location.pathname + '#feed{$_GET['idShowPost']}';</script>";
  exit;
}
  // Fonction pour générer un tableau de données avec les valeurs des variables ajoutées chaque heure
  if(isset($_POST['searchPost'])) {
    $getint = (int) $_POST['searchPost'];
    if(!empty($_POST['idPost'])) {
      $postSearch = getPostById($_POST['idPost']);
      
    }
    // $postSearch = getPostById($_POST['idPost']);
    // if(!empty($postSearch)) {
    //   echo "<script>window.location.href = window.location.pathname + '#feed{$_POST['idPost']}';</script>";
    //   exit;
    // }
  }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="./assets/css/style.css" />
    <link rel="stylesheet" href="./assets/css/profile.css" />
    <title>AdminSite</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  </head>
  <body>
    <!-- SIDEBAR -->
    <section id="sidebar">
      <a href="#" class="brand"><i class="bx bxs-smile icon"></i> AdminJokko</a>
      <ul class="side-menu">
        <li>
          <a href="#" class="" data-target="dashboard">
            <i class="bx bxs-dashboard icon"></i> Tableau de Bord
          </a>
        </li>
        <li>
          <a href="#" data-target="users">
            <i class="bx bx-user icon"></i> Utilisateurs
          </a>
        </li>
        <li>
          <a href="#" data-target="publications">
            <i class="bx bxs-chart icon"></i> Publications
          </a>
        </li>
        <li>
          <a href="#" data-target="signals">
            <i class="bx bxs-bell icon"></i> Signales
          </a>
        </li>

      </ul>
      
    </section>
    <!-- SIDEBAR -->

    <!-- NAVBAR -->
    <section id="content">
      <!-- NAVBAR -->
      <nav>
        <i class="bx bx-menu toggle-sidebar"></i>
        <form action="#">
          <div class="form-group"></div>
        </form>
        <div class="profile">
          <img
            src="./assets/images/profile/<?=$users['photoProfil']?>"
            alt=""
          />
          <ul class="profile-link">
            <li>
              <a href="?disconnect=1"><i class="bx bxs-log-out-circle"></i>Se déconnecter</a>
            </li>
          </ul>
        </div>
      </nav>
      <!-- NAVBAR -->

      <!-- MAIN -->
      <main class="" id="dashboard" data-target="mainDashboard">
        <h1 class="title">Tableau de bord</h1>
        <div class="info-data">
          <div class="card">
            <div class="head">
              <h2><?=$numberUser?></h2>
              <p>Utilisateurs</p>
              <i class="bx bxs-user-circle icon"></i>
            </div>
          </div>
          <div class="card">
            <div class="head">
              <h2><?=$numberPost?></h2>
              <p>Publications</p>
              <i class="bx bx-share-alt icon"></i>
            </div>
          </div>
          <div class="card">
            <div class="head">
              <h2><?=$numberConnect?></h2>
              <p>Connexions</p>
              <i class="bx bx-user-voice icon"></i>
            </div>
          </div>
        </div>
        <div class="data">
          <div class="content-data">
            <div class="head">
              <h3>Analyse</h3>
              <div class="menu">
                <i class="bx bx-dots-horizontal-rounded icon"></i>
                <ul class="menu-link">
                  <li><a href="#">Edit</a></li>
                  <li><a href="#">Save</a></li>
                  <li><a href="#">Remove</a></li>
                </ul>
              </div>
            </div>
            <div class="chart">
            <div>
  <canvas id="myChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
          const ctx = document.getElementById('myChart');

          new Chart(ctx, {
            type: 'bar',
            data: {
              labels: <?php echo json_encode($tabHeure) ?>,
              datasets: [{
                label: 'Utilisateurs',
                data: <?php echo json_encode($tabUser) ?>,
                borderWidth: 1
              },
              {
                label: 'Publications',
                data:<?php echo json_encode($tabPost) ?>,
                borderWidth: 1
              },
              {
                label: 'Connexions',
                data:<?php echo json_encode($tabConn) ?>,
                borderWidth: 1
              }
            ]
            },
            options: {
              scales: {
                y: {
                  beginAtZero: true
                }
              }
            }
          });
              </script>

              </div>
            </div>
          </div>
        </div>
      </main>
      <!-- MAIN -->
      <!-- MAIN -->
      <main class="" id="users" data-target="mainUser">
        <h1 class="title">Utilisateurs</h1>
        <div class="info-data">
          <div class="card">
            <div class="head">
              <h2><?=$numberUser?></h2>
              <p>Utilisateurs</p>
              <i class="bx bxs-user-circle icon"></i>
            </div>
          </div>
          <div class="card">
            <div class="head">
              <h2><?=$numberPost?></h2>
              <p>Publications</p>
              <i class="bx bx-share-alt icon"></i>
            </div>
          </div>
          <div class="card">
            <div class="head">
              <h2><?=$numberConnect?></h2>
              <p>Connexions</p>
              <i class="bx bx-user-voice icon"></i>
            </div>
          </div>
        </div>
        <div class="data">
          <div class="content-data">
            <div class="head">
              <h3>Tableau des utilisateurs</h3>
            </div>
            <div class="chart">
              <!-- header -->
              <div class="table__header">
              <div class="export__file">
                  <label
                    for="export-file"
                    class="export__file-btn"
                    title="Export File"
                  ></label>
                  <input type="checkbox" id="export-file" />
                  <div class="export__file-options">
                    <label>Export As &nbsp; &#10140;</label>
                    <label for="export-file" id="toPDF"
                      >PDF <img src="./assets/images/pdf.png" alt=""
                    /></label>
                    <label for="export-file" id="toJSON"
                      >JSON <img src="./assets/images/json.png" alt=""
                    /></label>
                    <label for="export-file" id="toCSV"
                      >CSV <img src="./assets/images/csv.png" alt=""
                    /></label>
                    <label for="export-file" id="toEXCEL"
                      >EXCEL <img src="./assets/images/excel.png" alt=""
                    /></label>
                  </div>
                </div>
                <div class="input-group">
                  <input type="search" placeholder="Search Data..." />
                  <img src="./assets/images/search.png" alt="" />
                </div>
                <div>
                
                </div>
              </div>
              <!-- body -->
              <div class="table__body">
                <table>
                  <thead>
                    <tr>
                      <th>Id <span class="icon-arrow">&UpArrow;</span></th>
                      <th>
                        Prenom & Nom <span class="icon-arrow">&UpArrow;</span>
                      </th>
                      <th>
                        Connexions
                        <span class="icon-arrow">&UpArrow;</span>
                      </th>
                      <th>
                        Publications
                        <span class="icon-arrow">&UpArrow;</span>
                      </th>
                      <th>Actions <span class="icon-arrow">&UpArrow;</span></th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                      foreach($allUsers as $user) {
                    ?>
                    <tr>
                      <td><?=$user['id']?></td>
                      <td class="prof">
                        <img
                          src="./assets/images/profile/<?=$user['photoProfil']?>"
                          alt=""
                        /><?=$user['prenom'] . " ". $user['nom']?>
                      </td>
                      <td><?=getNumberConnById($user['id'])?></td>
                      <td><?=getNumberPostById($user['id'])?></td>
                      <td>
                        <?php
                          if($user['statutAdmin'] == 1) {
                        ?>
                        <a href="./dao/ajax.php?idBlock=<?=$user['id']?>">
                          <p class="status cancelled">Bloquer</p>
                        </a>
                        <?php
                          }else{
                        ?>
                        <a href="./dao/ajax.php?idUnBlock=<?=$user['id']?>">
                          <p class="status delivered">Debloquer</p>
                        </a>
                        <?php
                          }
                        ?>
                      </td>
                    </tr>
                    <?php
                      }
                    ?>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </main>
      <!-- MAIN -->
      <main class="" id="publications" data-target="mainPost">
        <h1 class="title">Publications</h1>
        <div class="info-data">
          <div class="card">
            <div class="head">
              <h2><?=$numberUser?></h2>
              <p>Utilisateurs</p>
              <i class="bx bxs-user-circle icon"></i>
            </div>
          </div>
          <div class="card">
            <div class="head">
              <h2><?=$numberPost?></h2>
              <p>Publications</p>
              <i class="bx bx-share-alt icon"></i>
            </div>
          </div>
          <div class="card">
            <div class="head">
              <h2><?=$numberConnect?></h2>
              <p>Connexions</p>
              <i class="bx bx-user-voice icon"></i>
            </div>
          </div>
        </div>
        <div class="data">
          <div class="content-data">
            <div class="head">
              <h3>Toutes Les Publications</h3>
              <form action="" method="post" class="navSearch">
                <input type="text" name="idPost" placeholder="Saisir l'id...">
                <button type="submit" name="searchPost"><i class='bx bx-search icon' ></i></button>
              </form>
              
            </div>
            
            <div class="chart middle">
              <div class="feeds">
                <?php
                  foreach($allPosts as $post) {
                    $likes = $conn->prepare("SELECT id FROM likes WHERE post_id = ? ");
                    $likes->execute(array($post['postId']));
                    $likes = $likes->rowCount();
                    $nbrCom = $conn->prepare("SELECT id FROM commentaires WHERE post_id = ? ");
                    $nbrCom->execute(array($post['postId']));
                    $nbrCom = $nbrCom->rowCount();
                    $comments = showAllComments($post['postId']);
                    if($post['typeUser'] != "admin"){
                      if(isset($_POST['searchPost']) AND !empty($_POST['idPost'])){
                        $postSearch = getPostById($_POST['idPost']);
                        if($postSearch){
                ?>
                <div class="feed" id="<?="feed".$postSearch['postId']?>" >
                  <div class="head">
                    <div class="user">
                      <div class="profile-photo">
                        <img src="./assets/images/profile/<?=$postSearch['photoProfil']?>" alt="" />
                      </div>
                      <div class="info">
                        <h3><?=$postSearch['prenom'] . " " . $postSearch['nom']?></h3>
                        <small><?=calculerDuree($postSearch['dateCreate'])?> AGO</small>
                      </div>
                    </div>
                    <span class="edit">
                      <?php
                        if($postSearch['statutAdmin'] == 1){
                      ?>
                      <a href="index.php?page=profile&idDelPost=<?=$postSearch['postId']?>">
                        <i class="bx bx-trash icon"></i>
                      </a>
                      <?php
                        }else{
                      ?>
                      <a href="index.php?page=profile&idShowPost=<?=$postSearch['postId']?>">
                        <i class="bx bx-show icon" ></i>
                      </a>
                      <?php
                        }
                      ?>
                    </span>
                  </div>
                  <div class="ptext">
                    <p><?=$postSearch['post_text']?></p>
                  </div>

                  <div class="photo">
                    <img src="./assets/images/posts/<?=$postSearch['post_img']?>" alt="" />
                  </div>
                  <div class="liked-by">
                    <p><b><?=$likes?></b> aimes et <b><?=$nbrCom?></b> commentaires</p>
                  </div>

                  <div class="caption">
                    <?php
                      foreach($comments as $comment){
                    ?>
                    <p><b><?=$comment['prenom'] . " ". $comment['nom']?></b> <?=$comment['commentaire']?></p>
                  <div class="comments text-muted"><?=calculerDuree($comment['dateCommentaire'])?></div>
                    
                    <?php
                      }
                    ?>
                  </div>
                  
                </div>
                <?php break; unset($_POST['idPost']); exit;}}else{ ?>
                <div class="feed" id="<?="feed".$post['postId']?>" >
                  <div class="head">
                    <div class="user">
                      <div class="profile-photo">
                        <img src="./assets/images/profile/<?=$post['photoProfil']?>" alt="" />
                      </div>
                      <div class="info">
                        <h3><?=$post['prenom'] . " " . $post['nom']?></h3>
                        <small><?=calculerDuree($post['dateCreate'])?> AGO</small>
                      </div>
                    </div>
                    <span class="edit">
                      <?php
                        if($post['statutAdmin'] == 1){
                      ?>
                      <a href="index.php?page=profile&idDelPost=<?=$post['postId']?>">
                        <i class="bx bx-trash icon"></i>
                      </a>
                      <?php
                        }else{
                      ?>
                      <a href="index.php?page=profile&idShowPost=<?=$post['postId']?>">
                        <i class="bx bx-show icon" ></i>
                      </a>
                      <?php
                        }
                      ?>
                    </span>
                  </div>
                  <div class="ptext">
                    <p><?=$post['post_text']?></p>
                  </div>

                  <div class="photo">
                    <img src="./assets/images/posts/<?=$post['post_img']?>" alt="" />
                  </div>
                  <div class="liked-by">
                    <p><b><?=$likes?></b> aimes et <b><?=$nbrCom?></b> commentaires</p>
                  </div>

                  <div class="caption">
                    <?php
                      foreach($comments as $comment){
                    ?>
                    <p><b><?=$comment['prenom'] . " ". $comment['nom']?></b> <?=$comment['commentaire']?></p>
                  <div class="comments text-muted"><?=calculerDuree($comment['dateCommentaire'])?></div>
                    
                    <?php
                      }
                    ?>
                  </div>
                  
                </div>
                <?php
                      }
                    }
                  }
                ?>
                <!--==========END OF FEED=============-->
              </div>
              
            </div>
          </div>
        </div>
      </main>
      <!-- MAIN -->
      <main class="" id="signals" data-target="mainSignal">
        <h1 class="title">Signales</h1>
        <div class="info-data">
          <div class="card">
            <div class="head">
              <h2><?=$numberUser?></h2>
              <p>Utilisateurs</p>
              <i class="bx bxs-user-circle icon"></i>
            </div>
          </div>
          <div class="card">
            <div class="head">
              <h2><?=$numberPost?></h2>
              <p>Publications</p>
              <i class="bx bx-share-alt icon"></i>
            </div>
          </div>
          <div class="card">
            <div class="head">
              <h2><?=$numberConnect?></h2>
              <p>Connexions</p>
              <i class="bx bx-user-voice icon"></i>
            </div>
          </div>
        </div>
        <div class="data">
          <div class="content-data">
            <div class="head">
              <h3>Signales</h3>
            </div>
            <div class="chat-box">
            <?php foreach($allSignal as $signal){ ?>
              <div class="msg me">
                <div class="chat">
                  <div class="profile">
                    <span class="time"><?=calculerDuree($signal['dateSignale'])?></span>
                  </div>
                  <p>
                    <?=$signal['prenom']. " " .$signal['nom'] . " " . $signal['msg'] . " la publication identifié <b><u>N° " .$signal['idPost'] . "</u></b>"?>
                  </p>
                </div>
              </div>
            <?php } ?>
            </div>
          </div>
        </div>
      </main>
    </section>
    <!-- NAVBAR -->

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="./assets/js/script.js"></script>
    <script src="./assets/js/script2.js"></script>
    <script src="./assets/js/script3.js"></script>
    <script src="./assets/js/script4.js"></script>

  </body>
</html>
