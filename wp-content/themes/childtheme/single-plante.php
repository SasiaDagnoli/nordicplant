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
    <section id="primary" class="content-area">
        <button class="back">Tilbage</button>
    </section>

    <article class="single_planter">
        <img class="billedesingle" src="" alt="">
        <button class="videre"><img src="http://sasiadagnoli.dk/kea/nordicplant/wordpress/wp-content/themes/childtheme/images/pil-h%C3%B8jre.png" alt=""></button>
        <button class="tilbage"><img src="http://sasiadagnoli.dk/kea/nordicplant/wordpress/wp-content/themes/childtheme/images/pil-venstre.png" alt=""></button>
        <div>
            <div id="single_navn">
                <h2 class="plantenavn"></h2>
            </div>
            <p class="pris"></p>
            <p class="beskrivelse"></p>
            <div class="pasning">
                <p class="vandp">Vandmængde<img class="vand" src="" alt=""></p>
                <p class="solp">Sollys<img class="sol" src="" alt=""></p>
            </div>
            <button class="addbasket">Tilføj til kurv</button>

        </div>
    </article>

</main>

<script>
    let plante;
    let slideshow = [];
    const videreKnap = document.querySelector(".videre");
    const tilbageKnap = document.querySelector(".tilbage");
    let i = 1;
    let billeder = document.querySelector(".billedesingle");
    /* billeder.src = slideshow[1];*/

    videreKnap.addEventListener("click", nextPic);
    tilbageKnap.addEventListener("click", nextPic2);


    // php kode, som ud fra sluggen henter ID'et som et et tal

    const dbUrl = "http://sasiadagnoli.dk/kea/nordicplant/wordpress/wp-json/wp/v2/plante/" + <?php echo get_the_ID() ?>;


    async function getJson() {
        const data = await fetch(dbUrl);
        plante = await data.json();

        visPlanter();
        tilbageClick();
    }

    function tilbageClick() {
        document.querySelector(".back").addEventListener("click", goBack);
    }

    function goBack() {
        window.history.back();
    }

    function visPlanter() {
        console.log("visPlanter");
        console.log(plante.title.rendered);

        document.querySelector(".plantenavn").textContent = plante.title.rendered;
        /*document.querySelector(".billedesingle").src = plante.billede.guid;*/
        document.querySelector(".pris").textContent = plante.pris;
        document.querySelector(".beskrivelse").textContent = plante.beskrivelse;
        document.querySelector(".vand").src = plante.vand.guid;
        document.querySelector(".sol").src = plante.sol.guid;

        if (plante.ekstrabillede.guid != undefined) {
            i = 2;
        }
        slideshow.push(document.querySelector(".billedesingle").src = plante.close_up.guid);

        console.log(plante.ekstrabillede.guid);
        if (plante.ekstrabillede.guid != undefined) {
            slideshow.push(document.querySelector(".billedesingle").src = plante.ekstrabillede.guid);
        }
        slideshow.push(document.querySelector(".billedesingle").src = plante.billede.guid);



    }

    function nextPic() {
        console.log("Klikket på videre");
        console.log(slideshow[0]);
        console.log(slideshow[1]);
        if (i == slideshow.length - 1) {
            i = -1;
        }
        i++;
        billeder.src = slideshow[i];


    }

    function nextPic2() {
        if (i == 0) {
            i = slideshow.length;
        }
        i--;
        billeder.src = slideshow[i];
    }


    getJson();

</script>

<?php
get_footer();
