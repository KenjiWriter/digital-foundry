<script setup lang="ts">
import { ref, onMounted, onUnmounted, watch } from 'vue';
import * as THREE from 'three';
import { useWindowScroll } from '@vueuse/core';

const containerRef = ref<HTMLElement | null>(null);
let scene: THREE.Scene;
let camera: THREE.PerspectiveCamera;
let renderer: THREE.WebGLRenderer;
let globeVisual: THREE.LineSegments;
let animationId: number;

// Physics State
const { y: scrollY } = useWindowScroll(); // Reactive scroll
let lastScrollY = 0;
let rotationVelocity = 0.002;
const BASE_SPEED = 0.002;

// Interaction State
const mouse = new THREE.Vector2(0, 0); // Center default

// Transition State
const isTransitioning = ref(false);

const init = () => {
    if (!containerRef.value) return;

    // SCENE
    scene = new THREE.Scene();
    scene.background = null;

    // CAMERA
    camera = new THREE.PerspectiveCamera(75, containerRef.value.clientWidth / containerRef.value.clientHeight, 0.1, 1000);
    camera.position.z = 2.2; // Slightly closer for impact

    // RENDERER
    renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
    renderer.setSize(containerRef.value.clientWidth, containerRef.value.clientHeight);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2)); // Performance cap
    containerRef.value.appendChild(renderer.domElement);

    // GEOMETRY
    const geometry = new THREE.IcosahedronGeometry(1.2, 5);
    
    // 1. Visual Wireframe
    const wireframeGeometry = new THREE.WireframeGeometry(geometry);
    const material = new THREE.LineBasicMaterial({
        color: 0xf97316, // Start Orange (Loading)
        transparent: true,
        opacity: 1,
        linewidth: 1
    });
    globeVisual = new THREE.LineSegments(wireframeGeometry, material);
    scene.add(globeVisual);

    // EVENTS
    // window.addEventListener('resize', onWindowResize); // Replaced by ResizeObserver
    window.addEventListener('mousemove', onMouseMove);

    // ResizeObserver for Container Transition
    const resizeObserver = new ResizeObserver(() => {
        onWindowResize();
    });
    resizeObserver.observe(containerRef.value);

    animate();
    
    // Simulate Loading Transition
    setTimeout(() => {
        startTransition();
    }, 1200);
};

const startTransition = () => {
    isTransitioning.value = true;
    
    // Visual Shift
    const mat = globeVisual.material as THREE.LineBasicMaterial;
    mat.color.setHex(0x3b82f6); // Brand Blue
    mat.opacity = 0.2;
};

const onMouseMove = (event: MouseEvent) => {
    if (!containerRef.value) return;
    const rect = containerRef.value.getBoundingClientRect();
    // Normalized Device Coordinates (-1 to +1)
    mouse.x = ((event.clientX - rect.left) / rect.width) * 2 - 1;
    mouse.y = -((event.clientY - rect.top) / rect.height) * 2 + 1;
};

const animate = () => {
    animationId = requestAnimationFrame(animate);

    // 1. ROTATION PHYSICS
    const currentScrollY = scrollY.value;
    const scrollDelta = currentScrollY - lastScrollY;
    lastScrollY = currentScrollY;

    // Add scroll impulse to velocity
    rotationVelocity += scrollDelta * 0.0005;
    
    // Decay velocity back to base speed
    rotationVelocity += (BASE_SPEED - rotationVelocity) * 0.05;

    // Apply Rotation
    globeVisual.rotation.y += rotationVelocity;
    
    // 2. MOUSE STEERING (Look at cursor)
    // Target rotations based on mouse position
    const targetX = mouse.y * 0.5; // Tilt up/down
    const targetY = mouse.x * 0.5; // Spin left/right bonus

    // Lerp current extra rotation towards target
    // We can add this ON TOP of the base spin.
    
    // Smoothly interpolate the TILT (X axis)
    globeVisual.rotation.x += (targetX - globeVisual.rotation.x + (currentScrollY * 0.0002)) * 0.05;

    // Smoothly add extra Y rotation (steering)
    // Note: globeVisual.rotation.y is already incrementing, so we can't lerp it to a static value easily.
    // Instead, we modify rotation velocity or add a temporary offset. 
    // User requested: "mouse position tracking... rotation.y = mouseX * 0.5".
    // If we set rotation.y directly, we lose the spin.
    // User formula: "targetRotationY = mouseX * 0.5... finalRotationY = scrollRotation + targetRotationY".
    
    // Let's separate the "Spin" container from the "Tilt" container? 
    // Or just mathematically add them.
    // Simpler: Just nudge the rotation velocity based on mouse X? 
    // OR: `globeVisual.rotation.y = accumulatedSpin + (mouse.x * 0.5)`
    
    // We need to track accumulated spin separately to allow direct steering overlay.
    if (!globeVisual.userData.accumulatedY) globeVisual.userData.accumulatedY = 0;
    globeVisual.userData.accumulatedY += rotationVelocity;

    globeVisual.rotation.y = globeVisual.userData.accumulatedY + (mouse.x * 0.5);

    renderer.render(scene, camera);
};

const onWindowResize = () => {
    if (!camera || !renderer || !containerRef.value) return;
    const width = containerRef.value.clientWidth;
    const height = containerRef.value.clientHeight;
    
    camera.aspect = width / height;
    camera.updateProjectionMatrix();
    renderer.setSize(width, height);
};

onMounted(() => {
    init();
});

onUnmounted(() => {
    window.removeEventListener('resize', onWindowResize);
    window.removeEventListener('mousemove', onMouseMove);
    cancelAnimationFrame(animationId);
    
    if (renderer) renderer.dispose();
});
</script>

<template>
    <div ref="containerRef" class="w-full h-full pointer-events-none"></div>
</template>
