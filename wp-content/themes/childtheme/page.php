<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @see 		https://codex.wordpress.org/Theme_Development
 * @author  	Mahdi Yazdani
 * @package 	Hypermarket
 * @since 		1.0.0
 */


get_header();


if (have_posts()) :
	get_template_part('loop-templates/content', 'page');
else:
	get_template_part('loop-templates/content', 'none');
endif;



get_footer();
 ?>

<template>
    <article class="popular">
        <div class="imgpopularcontainer">
            <img class="imgpopular" src="" alt="">
        </div>
        <div>
            <h2 class="plantenavn"></h2>
            <p class="pris"></p>
        </div>
    </article>
</template>

<main id="main" class="site-main">
    <section id="primary" class="content-area"></section>

    <section class="section.elementor-section.elementor-top-section.elementor-element.elementor-element-839098a.elementor-section-boxed.elementor-section-height-default.elementor-section-height-default"></section>

</main>

<script>
    let planter;
    let categories;

    const catUrl = "http://sasiadagnoli.dk/kea/nordicplant/wordpress/wp-json/wp/v2/categories?per_page100";

    const dbUrl = "http://sasiadagnoli.dk/kea/nordicplant/wordpress/wp-json/wp/v2/plante?per_page100";

    async function getJson() {
        const data = await fetch(dbUrl);
        const catdata = await fetch(catUrl);

        planter = await data.json();
        categories = await catdata.json();
        console.log("planter", planter);
        visPopular();
    }

    function visPopular() {
        let temp = document.querySelector("template");
        let container = document.querySelector("section.elementor-section.elementor-top-section.elementor-element.elementor-element-839098a.elementor-section-boxed.elementor-section-height-default.elementor-section-height-default");
        /*container.innerHTML = "";*/
        planter.forEach(plante => {
            if (plante.categories.includes(23)) {
                let klon = temp.cloneNode(true).content;
                klon.querySelector("h2").textContent = plante.title.rendered;
                //Guid = noget fra vores JSON
                klon.querySelector(".imgpopular").src = plante.billede.guid;
                klon.querySelector(".pris").textContent = plante.pris;
                klon.querySelector(".vand").src = plante.vand.guid;
                klon.querySelector(".sol").src = plante.sol.guid;

                klon.querySelector("article").addEventListener("click", () => {
                    location.href = plante.link;
                })

                container.appendChild(klon);
            }

        })
    }
    getJson();

</script>

<style>
    @import url("https://use.typekit.net/vcg6uht.css");
    @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap');

</style>
