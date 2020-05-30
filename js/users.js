(function($) {
    $(document).ready(() => {
        let users = new Users()
        
        handleIDClick()
        handleNameClick()

        function handleIDClick() {
            users.listenToUserIdClicks()
            users.listenToUsernameClicks()

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
                    details = await users.getUserDetail("name", name)
                    users.validateResultByName(details)
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
                let id = parseInt($(this).html().trim())
                dispatch(Users.ID_CLICKED, {id: id})
            })
        }

        listenToNameClicks() {
            $("#users .user-name").on("click", function(e) {
                e.preventDefault();
                let name = $(this).html().trim()
                dispatch(Users.NAME_CLICKED, {name: name})
            })
        }

        listenToUsernameClicks() {
            $("#users .user-username").on("click", function(e) {
                e.preventDefault();
                let id = parseInt($(this).attr("id").trim())
                dispatch(Users.ID_CLICKED, {id: id})
            })
        }

        // Validation
        validateId(id) {
            if (!Number.isInteger(id)) {
                throw "Invalid ID"
            }
        }

        validateResultById(details) {
            if (details['id'] != this.latestDataBeingProcessed)
                throw { id: 0, message: ""}
        }

        validateResultByName(details) {
            if (details[0]['name'] != this.latestDataBeingProcessed)
                throw { id: 0, message: ""}
            
            if (details["message"] != undefined) {
                throw { id: 1, message: details["message"]} 
            }
            
            if (!Array.isArray(details)) {
                throw { id: 2, message: "Expected Array"} 
            }

            if (details.length != 1) {
                throw { id: 3, message: "Expected only length of 1, returns " + details.length } 
            }
        }

        validateResultByUsername(details) {
            console.log(this.latestDataBeingProcessed)
            if (details['username'] != this.latestDataBeingProcessed)
                throw { id: 0, message: ""}

            if (details["message"] != undefined) {
                throw { id: 1, message: details["message"]} 
            }

            if (!Array.isArray(details)) {
                throw { id: 2, message: "Expected Array"} 
            }

            if (details.length != 1) {
                throw { id: 3, message: "Expected only length of 1, returns " + details.length } 
            }
        }

        handleErrorById(err) {
            if (err.id != 0)
                this.showError(err)
        }

        handleErrorByName(err) {
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
})(jQuery);