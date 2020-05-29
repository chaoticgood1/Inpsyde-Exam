(function($) {
    $(document).ready(() => {
        let users = new Users()
        
        handleIDClick()
        handleNameClick()
        handleUserNameClick()

        
        function handleIDClick() {
            users.listenToUserIdClicks()
            window.addEventListener(Users.ID_CLICKED, async (e) => {
                let id = e.detail.id
                try {
                    users.showLoading()
                    users.validateId(id)
                    details = await users.getUserDetailById(id)
                    users.validateResultById(details)
                    let elementString = users.getElementString(details)
                    users.showDetails(elementString)
                } catch (errMsg) {
                    users.handleErrorById(errMsg)
                }
            })
        }
        
        function handleNameClick() {
            users.listenToNameClicks()
            window.addEventListener(Users.NAME_CLICKED, async (e) => {
                let name = e.detail.name
                try {
                    users.showLoading()
                    users.validateName(name)
                    details = await users.getUserDetail("name", name)
                    users.validateResultByName(details)
                    let elementString = users.getElementString(details[0])
                    users.showDetails(elementString)
                } catch (errMsg) {
                    users.handleErrorByName(errMsg)
                }
            })
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

        listenToNameClicks() {
            $("#users .user-name").on("click", function(e) {
                e.preventDefault();
                let name = $(this).html()
                console.log("name " + name)
                dispatch(Users.NAME_CLICKED, {name: name})
            })
        }

        // Validation
        validateId(id) {
            if (!Number.isInteger(id)) {
                throw "Invalid ID"
            }
        }


        validateName(name) {
            // TODO: Add more validation
            // - Should have no number
            // - Special characters?
        }

        validateResultByName(details) {
            if (details["message"] != undefined) {
                throw details["message"]
            }

            if (Array.isArray(details) && details.length == 1) {
                return true
            }
            return false
        }

        validateResultById(details) {
            // TODO: Add more validation
        }


        // Error Handling
        handleErrorById(errMsg) {
            // TODO: Handle errors
            console.log(errMsg)
            this.showError(errMsg)
        }

        handleErrorByName(errMsg) {
            // TODO: Handle errors
            console.log(errMsg)
            this.showError(errMsg)
        }

        showError(msg) {
            let $details = $("#user-details")
            $details.empty()
            $details.append("Error: " + msg)
        }

        showLoading() {
            let $details = $("#user-details")
            $details.empty()
            $details.append("Loading...")
        }

        showDetails(elementString) {
            let $details = $("#user-details")
            $details.empty()
            $details.append(elementString)
        }

        getElementString(details) {
            let string = ""
            for (let key in details) {
                string += `
                <span style="display:block">
                    ${key}: ${JSON.stringify(details[key])}
                </span>`
            }
            return string
        }

        getUserDetailById(id) {
            let url = Users.API + "/" + id
            return get(url)
        }

        getUserDetail(key, value) {
            let url = Users.API + `/?${key}=${value}`
            return get(url)
        }
    }

    function dispatch(type, detail = {}) {
        window.dispatchEvent(new CustomEvent(type, {detail: detail}))
    }

    function get(url) {
        return fetch(url)
        .then(response => { return response.json() })
        .catch(() => { return {"message": "Unable to fetch data"} })
    }

    Users.API = "https://jsonplaceholder.typicode.com/users"
    Users.ID_CLICKED = "ID_CLICKED"
    Users.NAME_CLICKED = "NAME_CLICKED"
    Users.USERNAME_CLICKED = "USERNAME_CLICKED"
})(jQuery);