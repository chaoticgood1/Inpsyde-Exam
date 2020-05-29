(function($) {
    $(document).ready(() => {
        let users = new Users()
        users.listenToUserIdClicks()

        handleIDClick()
        handleNameClick()
        handleUserNameClick()

        
        function handleIDClick() {
            window.addEventListener(Users.ID_CLICKED, async (e) => {
                let id = e.detail.id
                if (users.isIdValid(id)) {
                    let details = await users.getUserDetail(id)
                    let elementString = users.getElementString(details)
                    users.showDetails(elementString)
                    return
                }
                // TODO: Handle invalid id
                console.log("Invalid id")
            })
        }
        
        function handleNameClick() {
            // TODO: Use functions in handleIDClick()
        }

        function handleUserNameClick() {
            // TODO: Use functions in handleIDClick()
        }
        
    })

    class Users {
        listenToUserIdClicks() {
            $("#users .user-id").on("click", function(e) {
                e.preventDefault();
                let id = parseInt($(this).html()) // Check for conversion error
                dispatch(Users.ID_CLICKED, {id: id})
            })
        }

        showDetails(elementString) {
            let $details = $("#user-details")
            $details.empty()
            $details.append(elementString)
        }

        getElementString(details) {
            console.log(details)
            let string = ""
            for (let key in details) {
                string += `
                <span style="display:block">
                    ${key}: ${JSON.stringify(details[key])}
                </span>`
            }
            return string
        }

        getUserDetail(id) {
            let url = Users.API + "/" + id
            return get(url)
        }

        isIdValid(id) {
            return Number.isInteger(id)
        }
    }

    function dispatch(type, detail = {}) {
        window.dispatchEvent(new CustomEvent(type, {detail: detail}))
    }

    function get(url) {
        return fetch(url)
        .then(response => { return response.json() })
        .catch(() => console.log(`Can’t access ${url} response. Blocked by browser?`))
    }

    Users.API = "https://jsonplaceholder.typicode.com/users"
    Users.ID_CLICKED = "ID_CLICKED"
})(jQuery);