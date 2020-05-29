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
                    users.latestDataBeingProcessed = id
                    users.showLoading()
                    users.validateId(id)
                    details = await users.getUserDetailById(id)
                    users.validateResultById(details)
                    let elementString = users.getElementString(details)
                    users.showDetails(elementString)
                } catch (err) {
                    users.handleErrorById(err)
                }
            })
        }
        
        function handleNameClick() {
            users.listenToNameClicks()
            window.addEventListener(Users.NAME_CLICKED, async (e) => {
                let name = e.detail.name
                try {
                    users.latestDataBeingProcessed = name
                    users.showLoading()
                    users.validateName(name)
                    details = await users.getUserDetail("name", name)
                    users.validateResultByName(details)
                    let elementString = users.getElementString(details[0])
                    users.showDetails(elementString)
                } catch (err) {
                    users.handleErrorByName(err)
                }
            })
        }

        function handleUserNameClick() {
            users.listenToUsernameClicks()
            window.addEventListener(Users.USERNAME_CLICKED, async (e) => {
                let username = e.detail.username
                try {
                    users.latestDataBeingProcessed = username
                    users.showLoading()
                    users.validateUsername(username)
                    details = await users.getUserDetail("username", username)
                    console.log(details)
                    users.validateResultByUsername(details)
                    let elementString = users.getElementString(details[0])
                    users.showDetails(elementString)
                } catch (err) {
                    users.handleErrorByName(err)
                }
            })
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
                dispatch(Users.NAME_CLICKED, {name: name})
            })
        }

        listenToUsernameClicks() {
            $("#users .user-username").on("click", function(e) {
                e.preventDefault();
                let username = $(this).html()
                dispatch(Users.USERNAME_CLICKED, {username: username})
            })
        }

        // Validation
        validateId(id) {
            if (Number.isInteger(id)) {
                throw "Invalid ID"
            }
        }


        validateName(name) {
            // TODO: Add more validation
            // - Should have no number
            // - Special characters?
            
        }

        validateUsername(username) {
            // TODO: Add more validation
            // - Special characters?
            
        }

        validateResultById(details) {
            // TODO: Add more validation
            if (details['id'] != this.latestDataBeingProcessed)
                throw { id: 0, message: ""}
        }

        validateResultByName(details) {
            if (details['name'] != this.latestDataBeingProcessed)
                throw { id: 0, message: ""}

            if (details["message"] != undefined) {
                throw { id: 1, message: details["message"]} 
            }

            if (!Array.isArray(details)) {
                // TODO: Update when creating unit tests
                throw { id: 2, message: "Expected Array"} 
            }

            if (details.length != 1) {
                throw { id: 3, message: "Expected only length of 1, returns " + details.length } 
            }
        }

        validateResultByUsername(details) {
            if (details['username'] != this.latestDataBeingProcessed)
                throw { id: 0, message: ""}

            if (details["message"] != undefined) {
                throw { id: 1, message: details["message"]} 
            }

            if (!Array.isArray(details)) {
                // TODO: Update when creating unit tests
                throw { id: 2, message: "Expected Array"} 
            }

            if (details.length != 1) {
                throw { id: 3, message: "Expected only length of 1, returns " + details.length } 
            }
        }


        // Error Handling
        handleErrorById(err) {
            // TODO: Handle errors
            console.log(err)
            if (err.id != 0)
                this.showError(err)
        }

        handleErrorByName(err) {
            // TODO: Handle errors
            console.log(err)
            if (err.id != 0)
                this.showError(err)
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
            let param = encodeURIComponent(value)
            let url = Users.API + `/?${key}=${param}`

            console.log(url)
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