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
        <img class="billedesingle" src="" alt="">
        <button class="videre">Videre</button>
        <button class="tilbage">Tilbage</button>
        <div>
            <h2 class="plantenavn"></h2>
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

        /*const slideshow = ["document.querySelector(".billedesingle ").src = plante.billede.guid", "document.querySelector(".billedesingle ").src = plante.close_up.guid"];
        const videreKnap = document.querySelector(".videre");
        let i = 0;
        let billedeSlide = document.getElementsByClassName("billedesingle");
        billedeSlide.src = slideshow[0];*/

        document.querySelector(".plantenavn").textContent = plante.title.rendered;
        document.querySelector(".billedesingle").src = plante.billede.guid;
        document.querySelector(".pris").textContent = plante.pris;
        document.querySelector(".beskrivelse").textContent = plante.beskrivelse;
        document.querySelector(".vand").src = plante.vand.guid;
        document.querySelector(".sol").src = plante.sol.guid;


        document.querySelector(".videre").addEventListener("click", nextPic);
        document.querySelector(".tilbage").addEventListener("click", nextPic);
    }

    function nextPic() {
        document.querySelector(".billedesingle").src = plante.close_up.guid;

    }

    getJson();

</script>

<?php
get_footer();
