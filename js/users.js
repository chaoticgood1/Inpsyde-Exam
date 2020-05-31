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
                    details = await users.getUserDetailById(id)\
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
            if (details['id'] != undefined && 
                details['id'] != this.latestDataBeingProcessed) {
                throw { id: Users.IGNORE_RESULT_CODE, message: ""}
            }
                

            this.genericValidation(details)
        }

        validateResultByName(details) {
            if (details[0] != undefined &&
                details[0]['name'] != undefined && 
                details[0]['name'] != this.latestDataBeingProcessed) {
                throw { id: Users.IGNORE_RESULT_CODE, message: ""}
            }
                
            this.genericValidation(details)

            if (!Array.isArray(details)) {
                throw { id: 2, message: "Expected Array"} 
            }

            if (details.length != 1) {
                throw { id: 3, message: "Expected only length of 1, returns " + details.length } 
            }
        }

        validateResultByUsername(details) {
            if (details['username'] != undefined && 
                details['username'] != this.latestDataBeingProcessed) {
                throw { id: Users.IGNORE_RESULT_CODE, message: ""}
            }
                
            this.genericValidation(details)
        }

        genericValidation(details) {
            if (details['message'] != undefined) {
                throw { 
                    id: Users.UNABLE_TO_FETCH_DATA_CODE, 
                    message: details['message']
                }
            }
            if (Object.keys(details).length == 0) {
                throw {
                    id: Users.EMPTY_DATA, 
                    message: "Return is empty"
                }
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

        showError(err) {
            let $details = $("#user-details")
            $details.empty()
            $details.append(`Error Code: ${err["id"]}, ${err["message"]}`)
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
    Users.UNABLE_TO_FETCH_DATA_CODE = 1
    Users.EMPTY_DATA = 4
    Users.IGNORE_RESULT_CODE = 0
})(jQuery);