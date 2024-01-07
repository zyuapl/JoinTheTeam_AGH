
const kolaSection = document.querySelector(".kolo");
const container = document.querySelector(".container");
const newKolo = document.createElement("div");
const lupo = document.createElement("div");
const glownyKolo = document.createElement("div");
glownyKolo.className = `kolo-child`;
const article = document.querySelector(".article");
siteButtons = [];
const categoryActive = document.querySelector(".category-active");
const categoryAll = document.querySelector(".category-all");

function render() {
    setTimeout(() => {
        siteButtons = document.querySelectorAll(".site");
        siteButtons.forEach((btn) => btn.addEventListener("click", goToSite));
    },100);
    glownyKolo.innerHTML = ``;
    fetch('./DB_json/organizations_info.json')
    .then(res => res.json())
    .then(data => {
        data.forEach(post => {
            const oldKolo = document.createElement("div");
            oldKolo.className = `kolo-item ${(post.isActiveRecrutation == 1) ? 'active' : ''}`;
            if (oldKolo.className == "kolo-item active") {
                oldKolo.innerHTML = 
                `
                <img src="images/${post.picture}" alt="" />
                <p class="item-name">${post.name}</p>
                <p class="item-description">${post.description_short}</p>
                <div class="item-more">
                <button class="site" data-id="${post.id}">Więcej...</button>
                <button class="item-recrutation" href="recrutation.php">Rekrutacja
                <span class="tooltiptext">Musisz być zalogowany!</span>
                </button>
                </div>
                `;  
            } else {
                oldKolo.innerHTML = 
                `
                <img src="images/${post.picture}" alt="" />
                <p class="item-name">${post.name}</p>
                <p class="item-description">${post.description_short}</p>
                <div class="item-more">
                <button class="site" data-id="${post.id}">Więcej...</button>
                <button class="item-recrutation" disabled>Rekrutacja</button>
                </div>
                `; 
            } 
            glownyKolo.appendChild(oldKolo); 
        });
        const siteButtons = document.querySelectorAll(".site");
    });
    kolaSection.appendChild(glownyKolo);
}

document.onload = render();

function category() {
    setTimeout(() => {
        siteButtons = document.querySelectorAll(".site");
        siteButtons.forEach((btn) => btn.addEventListener("click", goToSite));
    },100);
    glownyKolo.innerHTML = ``;
    fetch('./DB_json/organizations_info.json')
    .then(res => res.json())
    .then(data => {
        data.forEach(post => {
            const oldKolo = document.createElement("div");
            if (post.isActiveRecrutation == 1) {
            oldKolo.className = `kolo-item active`;
                oldKolo.innerHTML = 
                `
                <img src="images/${post.picture}" alt="" />
                <p class="item-name">${post.name}</p>
                <p class="item-description">${post.description_short}</p>
                <div class="item-more">
                <button class="site" data-id="${post.id}">Więcej...</button>
                <a class="item-recrutation" href="recrutation.php">Rekrutacja</a>
                </div>
                `;  
                glownyKolo.appendChild(oldKolo); 
            }
        })
    })

}

const goToSite = (e) => {
    const selectedId = parseInt(e.target.dataset.id);

    fetch('./DB_json/organizations_info.json')
    .then(res => res.json())
    .then (data => {
        data.forEach(post => {
            if (post.id == selectedId) {
                const popo = document.createElement("div");
                popo.className = `site_open`;
                if (post.isActiveRecrutation == 0) {
                popo.innerHTML = `
                <main class="containerpi">
                <div class="back">
                <button class="backbtn"><img src="./images/close-icon.png" alt="back" width="25px"></button>
                </div>
        <div class="title">
            <img id="org-pic" src="images/${post.picture}" width="300px" height="200px" alt="">
            <h1 class="org-name">${post.name}</h1>
        </div>
        <div class="articlepi">
            <section class="description">
                ${post.description_long}    
            </section>
            <section class="rec">
                <p class="recrutation_info">W tej chwili nie prowadzimy rekrutacji</p>
            </section>
        </div>
        </main>
                `;} else {
                    popo.innerHTML = `
                <main class="containerpi">
                <div class="back">
            <button class="backbtn"><img src="./images/close-icon.png" alt="back" width="25px"></button>
        </div>
        <div class="title">
            <img id="org-pic" src="images/${post.picture}" width="300px" height="200px" alt="">
            <h1 class="org-name">${post.name}</h1>
        </div>
        <div class="articlepi">
            <section class="description">
                ${post.description_long}    
            </section>
            <section class="rec">
                <p class="recrutation_info">Rekrutacja trwa!</p>
                <button class="btn" disabled>Rekrutacja</button>
            </section>
        </div>
        </main>
                `;
                }
                container.appendChild(popo);
                article.className = `article disactive`;
                backbutton = document.querySelector(".backbtn");
                backbutton.addEventListener("click", (e) => {
                    container.removeChild(popo);
                    article.className = `article`;
                }); 
            }
        });
        
    })
}

setTimeout(() => {
    siteButtons = document.querySelectorAll(".site");
            siteButtons.forEach((btn) => btn.addEventListener("click", goToSite));
            categoryActive.addEventListener("click", category);
            categoryAll.addEventListener("click", render);
        },100);
