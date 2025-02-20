document.addEventListener("DOMContentLoaded", function() {
    fetchGitHubStats();
});

function fetchGitHubStats() {
    const repoURL = "https://api.github.com/repos/Coding-Community-of-Central-Texas/NeverFear";

    fetch(repoURL)
        .then(response => response.json())
        .then(data => {
            if (data.stargazers_count && data.forks) {
                document.getElementById("github-button").innerText = `📂 View on GitHub (${data.stargazers_count} ★ | ${data.forks} 🍴)`;
                document.getElementById("github-button").onclick = function() {
                    window.open(data.html_url, "_blank");
                };
            }
        })
        .catch(error => console.error("GitHub API Error:", error));
}
