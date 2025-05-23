document.addEventListener("DOMContentLoaded", () => {
  // Get the sidebar toggle button and sidebar element
  const sidebarToggle = document.getElementById("sidebar-toggle");
  const sidebar = document.querySelector(".sidebar");
  const content = document.querySelector(".content");

  // Check if there's a saved state in localStorage
  const sidebarCollapsed = localStorage.getItem("sidebarCollapsed") === "true";

  // Apply the initial state
  if (sidebarCollapsed) {
    sidebar.classList.add("collapsed");
    content.classList.add("expanded");
  }

  // Add click event listener to the toggle button
  sidebarToggle.addEventListener("click", () => {
    // Toggle the collapsed class on the sidebar
    sidebar.classList.toggle("collapsed");

    // Toggle the expanded class on the content
    content.classList.toggle("expanded");

    // Trigger window resize to make charts responsive
    setTimeout(() => {
      window.dispatchEvent(new Event("resize"));
    }, 300);

    // Save the state to localStorage
    const isCollapsed = sidebar.classList.contains("collapsed");
    localStorage.setItem("sidebarCollapsed", isCollapsed);
  });
});
