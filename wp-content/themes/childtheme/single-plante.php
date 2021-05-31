<?php
/**
 * The template for displaying all single posts.
 *
 * @see 		http://codex.wordpress.org/Template_Hierarchy
 * @author  	Mahdi Yazdani
 * @package 	Hypermarket
 * @since 		1.0.0
 */

get_header();

?>

<main id="main" class="site-main">
    <section id="primary" class="content-area"></section>

    <article class="single_planter">
        <img class="billede" src="" alt="">
        <div>
            <h2 class="plantenavn"></h2>
            <p class="pris"></p>
            <p class="beskrivelse"></p>

        </div>
    </article>




</main>

<script>
    let plante;


    // php kode, som ud fra sluggen henter ID'et som et et tal

    const dbUrl = "http://sasiadagnoli.dk/kea/nordicplant/wordpress/wp-json/wp/v2/plante/" + <?php echo get_the_ID() ?>;

    async function getJson() {
        const data = await fetch(dbUrl);
        plante = await data.json();

        visPlanter();
    }

    function visPlanter() {
        console.log("visPlanter");
        console.log(plante.title.rendered);

        document.querySelector(".plantenavn").textContent = plante.title.rendered;
        document.querySelector(".billede").src = plante.billede.guid;
        document.querySelector(".pris").textContent = plante.pris;
        document.querySelector(".beskrivelse").textContent = plante.beskrivelse;
    }

    getJson();

</script>

get_footer();
