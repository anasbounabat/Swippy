import './bootstrap';
import React from 'react';
import { createRoot } from 'react-dom/client';
import CreateAd from './components/CreateAd';

// Alpine.js setup
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// React setup
if (document.getElementById('create-ad-form')) {
    const container = document.getElementById('create-ad-form');
    const root = createRoot(container);
    root.render(<CreateAd />);
}
