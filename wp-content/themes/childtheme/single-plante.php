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


<template>
    <article class="planter">
        <img class="billede" src="" alt="">
        <div>
            <h2 class="plantenavn"></h2>
            <p class="pris"></p>
            <p class="beskrivelse"></p>

        </div>
    </article>
</template>

<main id="main" class="site-main">
    <section id="primary" class="content-area"></section>

</main>

<script>

    let plante;

    // php kode, som ud fra sluggen henter ID'et som et et tal
    let aktuelplante = <?php echo get_the_ID() ?>;

     const dbUrl = "http://sasiadagnoli.dk/kea/nordicplant/wordpress/wp-json/wp/v2/plante/" + aktuelplante;

    async function getJson() {
        const data = await fetch(dbUrl);
        plante = await data.json();

        visPlanter();
    }

    function visPlanter() {
        console.log("visPlanter");
        console.log(plante.title.rendered);

        document.querySelector(".plantenavn").innerHTML = plante.title.rendered;
        document.querySelector(".billede").src = plante.billede.guid;
        document.querySelector(".pris").innerHTML = plante.content.rendered;
        document.querySelector(".beskrivelse").innerHTML = plante.content.rendered;
    }



</script>

get_footer();
