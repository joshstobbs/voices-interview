function handleRegionChange() {
    let countryInput = document.querySelector("#job-country")
    let regionLabel = document.querySelector("label[for='job-region']")
    let regionInput = document.querySelector("#job-region")
    let regionInputPlaceholder = regionInput.querySelector("option[disabled]")
    let labelContent = "Job State"
    let placeholerContent = "Select Your State"
    let resetButton = document.querySelector("button[type='reset']")

    countryInput.addEventListener("change", (event) => {
        let canadianOptions = regionInput.querySelectorAll("option[data-country='1']")
        let americanOptions = regionInput.querySelectorAll("option[data-country='2']")

        if (event.target.value === "1") {
            labelContent = "Job Province"
            placeholerContent = "Select Your Province"

            canadianOptions.forEach((el) => {
                el.removeAttribute("disabled")
                el.removeAttribute("hidden")
            })

            americanOptions.forEach((el) => {
                el.setAttribute("disabled", true)
                el.setAttribute("hidden", true)
            })
        } else {
            americanOptions.forEach((el) => {
                el.removeAttribute("disabled")
                el.removeAttribute("hidden")
            })

            canadianOptions.forEach((el) => {
                el.setAttribute("disabled", true)
                el.setAttribute("hidden", true)
            })
        }

        regionLabel.textContent = labelContent
        regionInputPlaceholder.textContent = placeholerContent
    })

    resetButton.addEventListener("click", () => {
        regionLabel.textContent = "Job State"
        regionInputPlaceholder.textContent = "Select Your State"
    })
}

function handleInfoCount() {
    let infoInput = document.querySelector("#job-additional-info")
    let wordCountSpan = document.querySelector("[data-word-count]")
    let wordPluralSpan = document.querySelector("[data-word-plural]")

    infoInput.addEventListener("keyup", (event) => {
        let wordCount = event.target.value.trim().replace(/\s+/gi, " ").split(" ").length

        wordPluralSpan.textContent = wordCount === 1 ? "" : "s"

        wordCountSpan.textContent = wordCount
    })
}

function handleFileInput() {
    let fileInput = document.querySelector("#attachment")
    let fileNameTarget = document.querySelector("[data-file-name]")
    let removeFileButton = document.querySelector(".button-remove")

    fileInput.addEventListener("change", (event) => {
        let fileName = event.target.files[0].name
        fileNameTarget.textContent = fileName
        removeFileButton.style.display = "inline-flex"
    })

    removeFileButton.addEventListener("click", (event) => {
        fileInput.value = null
        fileNameTarget.textContent = ""
        removeFileButton.style.display = "none"
    })
}

function handleReset() {
    let resetButton = document.querySelector("button[type='reset']")
    let wordCountSpan = document.querySelector("[data-word-count]")
    let wordPluralSpan = document.querySelector("[data-word-plural]")
    let fileNameTarget = document.querySelector("[data-file-name]")
    let removeFileButton = document.querySelector(".button-remove")

    resetButton.addEventListener("click", (event) => {
        wordPluralSpan.textContent = "s"
        wordCountSpan.textContent = 0

        fileNameTarget.textContent = ""
        removeFileButton.style.display = "none"
    })
}

function validateInput(selector, rules = { min: 3, max: 50 }) {
    let input = document.querySelector(selector)
    let value = input.value
    let messageContainer = input.nextElementSibling

    input.classList.remove("form-error")
    messageContainer.style.display = "none"

    if (value.length < rules.min || value.length > rules.max) {
        messageContainer.textContent = "Job Title length is incorrect."

        input.classList.add("form-error")
        messageContainer.style.display = "block"

        return false
    }

    return true
}

function handleSubmit() {
    let form = document.querySelector("form")
    let titleInput = form.querySelector("#job-title")
    let countryInput = form.querySelector("#job-country")
    let regionInput = form.querySelector("#job-region")
    let infoInput = form.querySelector("#job-additional-info")
    let fileInput = form.querySelector("#attachment")
    let tokenInput = form.querySelector("#csrf_token")
    let formAlert = form.querySelector(".form-alert")
    let formAlertMessage = formAlert.querySelector("p")
    let formAlertDismiss = formAlert.querySelector(".button-remove")

    form.addEventListener("submit", (event) => {
        event.preventDefault()

        if (!validateInput("#job-title")) {
            return
        }

        let endpoint = event.target.action

        let data = new FormData()

        data.append("job_title", titleInput.value)
        data.append("country_id", countryInput.value)
        data.append("region_id", regionInput.value)
        data.append("job_additional_info", infoInput.value)
        data.append("job_file", fileInput.files[0])
        data.append("csrf_token", tokenInput.value)

        try {
            fetch(endpoint, { method: "POST", body: data })
                .then((response) => response.json())
                .then((data) => {
                    formAlertMessage.textContent = "Awesome! Your job was submitted sucessfully!"

                    console.log(data)
                })
        } catch (error) {
            formAlertMessage.textContent = "Oh darn!  Something went wrong on our end, try again?"

            console.error(error)
        }

        formAlert.style.display = "flex"

        formAlertDismiss.addEventListener("click", (event) => {
            formAlert.style.display = "none"
        })
    })

    // form.addEventListener("submit", (event) => {
    //     event.preventDefault()
    // })
}

document.addEventListener(
    "DOMContentLoaded",
    function () {
        handleRegionChange()

        handleInfoCount()

        handleFileInput()

        handleReset()

        handleSubmit()
    },
    false
)
