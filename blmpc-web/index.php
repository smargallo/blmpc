<?php include 'layouts/header.php'; ?>
  <header id="header" class="fixed-top bg-success">
    <div class="container d-flex align-items-center">

      <h1 class="logo me-auto"><a href="index.php"><img src="assets/img/logo.png" alt="./"></a></h1>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
          <li class="dropdown"><a href="#"><span>About Us</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="about.php">About BLMPC</a></li>
              <li><a href="mvo.php">Mission, Vision and Objectives</a></li>
            </ul>
          </li>
          <li><a class="nav-link   scrollto" href="#portfolio">Upcoming Events</a></li>
          <li><a class="nav-link scrollto" href="#team">Organizational Chart</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav>

    </div>
  </header>

  <section id="hero" class="d-flex align-items-center">

    <div class="container">
      <div class="row">
        <div class="col-lg-8 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
          <h1>BLMPC</h1>
          <h2><span>B</span>liss <span>L</span>ingion <span>M</span>ulti-<span>P</span>urpose <span>C</span>ooperative
          </h2>
        </div>
        <div class="col-lg-4 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
          <img src="assets/img/logo.png" class="img-fluid animated" alt="">


        </div>
      </div>
    </div>

  </section>

  <main id="main">
    <section id="about" class="about">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>About Us</h2>
        </div>

        <div class="row content">
          <div class="col-lg-12">
            <b class="mb-3 text-center">
              <p>
                HISTORY OF BLISS LINGI-ON MULTI-PURPOSE COOPERATIVE
              </p>
            </b>
            <div class="col-lg-12 pt-8 pt-lg-0">
              <p class="about-just" id="about-just">
                The Bliss Lingion Multi-Purpose Cooperative organized in January 20, 1994, with the present Vice- Chairman
                of the Board Merelin Y. Galacio as the proponent. As a KAPUNUNGAN or a group lived in a community named
                Bagong Lipunan Improvement Site Services (BLISS) a housing project under Marcos administration. At that
                time theres no sari-sari store in the community and seeing the difficulties of the residents in their
                basic needs, the group agreed to put up 100 pesos each for a sari-sari store which will be placed at Wilma
                Galanido’s Residence wherein she will also be the caretaker. The group composed of 7 members namely
                Merelin Y. Galacio, Elma N. Mercado, Maxima Verador, Wilma Galanido, Clarita Nabora, Consorcia Bahian and
                Pastor G. Rapirap and were able to raised 800 pesos with only 7 members to start. The membership
                increased, the operation doing well and net income remarkable.
              </p>
              <a href="about.php" class="btn-learn-more">Read More</a>
            </div>
          </div>

        </div>
    </section>

    <section id="cta" class="cta">
      <div class="container" data-aos="zoom-in">

        <div class="row">
          <div class="col-lg-12 text-center text-lg-start">
            <h3 id="cta-h3">BLMPC</h3>
            <p> Bliss Lingion Multi-Purpose Cooperative </p>
          </div>
        </div>

      </div>
    </section>

    <section id="portfolio" class="portfolio  section-bg">
      <div class="container" data-aos="fade-up">



        <div class="section-title ">
          <h2>Events</h2>
        </div>

        <div class="container mt-5">
          <div id="eventCarousel" class="carousel slide" data-ride="carousel" data-interval="5000">


            <div class="carousel-inner">

              <?php
              include('../functions/connection.php');

              $sql = "SELECT * FROM events_tbl";
              $result = $conn->query($sql);

              if ($result->num_rows > 0) {
                $active = true;
                while ($row = $result->fetch_assoc()) {
              ?>
                  <div class="carousel-item <?php echo $active ? 'active' : ''; ?>">
                    <img src="../functions/<?php echo $row['image_path']; ?>" class="d-block w-100" alt="Event <?php echo $row['id']; ?>">

                  </div>
              <?php
                  $active = false;
                }
              } else {
                echo "No events found";
              }
              $conn->close();
              ?>

            </div>

            <a class="carousel-control-prev" href="#eventCarousel" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#eventCarousel" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
        </div>


      </div>
    </section>

    <section id="team" class="team">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Organizational Chart</h2>
          <p></p>
        </div>

        <div class="row">
          <div class="d-flex justify-content-center align-items-center image-container"" data-aos="zoom-in" data-aos-delay="100">
            <img src="./assets/img/chart.png" alt="" srcset="">
          </div>
      
        </div>

      </div>
    </section>

  </main>
<?php include 'layouts/footer.php'; ?>