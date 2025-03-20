import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', function() {
    // Homepage search
    const searchForm = document.querySelector('.search-form');
    const searchInput = document.getElementById('searchInput');
    const departmentSelect = document.getElementById('department');
    const sessionSelect = document.getElementById('session');
    const bloodGroupSelect = document.getElementById('blood_group');
    const genderSelect = document.getElementById('gender');

    // Dashboard search
    const dashboardSearchForm = document.querySelector('.dashboard-search-form');
    const dashboardSearch = document.getElementById('search');
    const dashboardDepartment = document.getElementById('department');
    const dashboardSession = document.getElementById('session');
    const dashboardSearchBtn = document.getElementById('searchBtn');

    // Prevent default form submission
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
        });
    }

    if (dashboardSearchForm) {
        dashboardSearchForm.addEventListener('submit', function(e) {
            e.preventDefault();
        });
    }

    let debounceTimer;

    const handleSearch = (e) => {
        if (e) e.preventDefault();
        
        const searchParams = new URLSearchParams(window.location.search);
        
        // Update search parameters for homepage
        if (searchInput) {
            if (searchInput.value) searchParams.set('search', searchInput.value);
            else searchParams.delete('search');
            
            if (departmentSelect.value) searchParams.set('department', departmentSelect.value);
            else searchParams.delete('department');
            
            if (sessionSelect.value) searchParams.set('session', sessionSelect.value);
            else searchParams.delete('session');
            
            if (bloodGroupSelect.value) searchParams.set('blood_group', bloodGroupSelect.value);
            else searchParams.delete('blood_group');
            
            if (genderSelect.value) searchParams.set('gender', genderSelect.value);
            else searchParams.delete('gender');
        }

        // Update URL and reload results
        window.location.href = `${window.location.pathname}?${searchParams.toString()}`;
    };

    const handleDashboardSearch = (e) => {
        if (e) e.preventDefault();
        
        const searchParams = new URLSearchParams(window.location.search);
        
        if (dashboardSearch.value) searchParams.set('search', dashboardSearch.value);
        else searchParams.delete('search');
        
        if (dashboardDepartment.value) searchParams.set('department', dashboardDepartment.value);
        else searchParams.delete('department');
        
        if (dashboardSession.value) searchParams.set('session', dashboardSession.value);
        else searchParams.delete('session');

        window.location.href = `${window.location.pathname}?${searchParams.toString()}`;
    };

    // Add event listeners for homepage
    if (searchForm) {
        searchForm.addEventListener('submit', handleSearch);
        
        // Add debounced input handler for real-time search
        searchInput.addEventListener('input', () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(handleSearch, 500);
        });

        // Add change handlers for filters
        [departmentSelect, sessionSelect, bloodGroupSelect, genderSelect].forEach(select => {
            if (select) select.addEventListener('change', handleSearch);
        });
    }

    // Add event listeners for dashboard
    if (dashboardSearchForm) {
        dashboardSearchForm.addEventListener('submit', handleDashboardSearch);
        
        // Add keyup handler for search input
        dashboardSearch.addEventListener('keyup', function(event) {
            if (event.key === 'Enter') {
                handleDashboardSearch(event);
            }
        });

        // Add click handler for search button
        if (dashboardSearchBtn) {
            dashboardSearchBtn.addEventListener('click', handleDashboardSearch);
        }

        // Add change handlers for filters
        [dashboardDepartment, dashboardSession].forEach(select => {
            if (select) select.addEventListener('change', handleDashboardSearch);
        });
    }
}
});
