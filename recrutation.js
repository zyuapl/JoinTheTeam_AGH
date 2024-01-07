
const org = document.querySelector(".org");

function renderMenu() {

    fetch('./DB_json/organizations_info.json')
    .then(res => res.json())
    .then(data => {
        data.forEach(post => {
            if (post.isActiveRecrutation==1) {
                const option = document.createElement("option");
                option.className = `option`;
                option.value = `${post.name}`;
                option.innerHTML = `${post.name}`;
                org.appendChild(option);
                console.log(post.name);
            }
        })
    })
}

document.onload = renderMenu();