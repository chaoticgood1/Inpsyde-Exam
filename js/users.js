(function($) {
    $(document).ready(() => {
        let users = new Users()
        users.listenToUserIdClicks()
        
        window.addEventListener(Users.ID_CLICKED, async (e) => {
            
            let id = e.detail.id
            if (users.isIdValid(id)) {
                let details = await users.getUserDetail(id)
                users.showDetails(details)
                return
            }
            // Handle invalid id
            console.log("Invalid id")
        })
    })

    class Users {
        listenToUserIdClicks() {
            $("#users .user-id").on("click", function(e) {
                console.log("Test")
                e.preventDefault();
                let id = parseInt($(this).html()) // Check for conversion error
                dispatch(Users.ID_CLICKED, {id: id})
            })
        }

        showDetails(details) {
            // let $details = $(".user-details")
            // details.empty()
            // details.append(`
            //     <span></span>
            // `)

            // $(".user-details").append()
            console.log(details)
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