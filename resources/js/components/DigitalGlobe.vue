<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import * as THREE from 'three';
import { useWindowScroll } from '@vueuse/core';

const containerRef = ref<HTMLElement | null>(null);
let scene: THREE.Scene;
let camera: THREE.PerspectiveCamera;
let renderer: THREE.WebGLRenderer;
let globeVisual: THREE.LineSegments;
let animationId: number;

// Physics State
const { y: scrollY } = useWindowScroll();
let lastScrollY = 0;
let rotationVelocity = 0.002;
const BASE_SPEED = 0.002;

// Interaction State
const mouse = new THREE.Vector2(0, 0);

// Transition State
const isTransitioning = ref(false);

// Flight System State
interface Flight {
    id: number;
    start: THREE.Vector3;
    end: THREE.Vector3;
    curve: THREE.QuadraticBezierCurve3;
    progress: number;
    speed: number;
    line: THREE.Object3D | null; // Can be Line or Mesh
    trail: THREE.Line | null;
}

// Flight System State - PLAIN ARRAY (NO VUE REACTIVITY for THREE.js)
let flights: Flight[] = []; // NOT ref() - Vue proxies break THREE.js cleanup!
const MAX_FLIGHTS = 5; // Hard limit to prevent lag
let flightInterval: number | null = null;

// Helper: Generate random point on sphere
const generateRandomCoords = (): THREE.Vector3 => {
    const phi = Math.random() * Math.PI * 2;
    const theta = Math.acos(2 * Math.random() - 1);
    const radius = 1.2;
    
    const x = radius * Math.sin(theta) * Math.cos(phi);
    const y = radius * Math.sin(theta) * Math.sin(phi);
    const z = radius * Math.cos(theta);
    
    return new THREE.Vector3(x, y, z);
};

// Spawn a new flight
const spawnFlight = () => {
    if (!scene || flights.length >= MAX_FLIGHTS) return; // Hard cap
    
    const id = Date.now() + Math.random();
    const start = generateRandomCoords();
    const end = generateRandomCoords();
    
    // Create curved path
    const curve = new THREE.QuadraticBezierCurve3(
        start,
        start.clone().lerp(end, 0.5).multiplyScalar(1.35), // Arc outward
        end
    );
    
    const flight: Flight = {
        id,
        start,
        end,
        curve,
        progress: 0,
        speed: 0.006 + Math.random() * 0.004, // Variable speed
        line: null,
        trail: null
    };
    
    flights.push(flight);
};

// Trail configuration
const TRAIL_LENGTH = 0.25; // 25% of total distance for comet effect

// Update all active flights
const updateFlights = () => {
    if (!scene || !globeVisual) return;
    
    flights.forEach(flight => {
        // Update progress
        flight.progress += flight.speed;
        
        // CRITICAL: Remove from scene FIRST, then dispose (don't null during render loop)
        if (flight.line) {
            globeVisual.remove(flight.line);
            if ('geometry' in flight.line && flight.line.geometry) {
                (flight.line.geometry as THREE.BufferGeometry).dispose();
            }
            if ('material' in flight.line && flight.line.material) {
                (flight.line.material as THREE.Material).dispose();
            }
            flight.line = null;
        }
        if (flight.trail) {
            globeVisual.remove(flight.trail);
            if (flight.trail.geometry) {
                flight.trail.geometry.dispose();
            }
            if (flight.trail.material) {
                (flight.trail.material as THREE.Material).dispose();
            }
            flight.trail = null;
        }
        
        // Comet physics: Head and Tail progress
        const tHead = Math.min(1, flight.progress); // Head stops at destination
        const tTail = Math.max(0, flight.progress - TRAIL_LENGTH); // Tail follows behind
        
        // Kill condition: Remove when tail reaches destination
        if (tTail >= 1) {
            flight.line = null;
            flight.trail = null;
            return;
        }
        
        // Head position (packet)
        const current = flight.curve.getPoint(tHead);
        
        // Create glowing "packet" at current position (ULTRA-SMALL for laser-thin lines)
        const packetGeometry = new THREE.SphereGeometry(0.003, 4, 4); // Ultra-thin laser!
        const packetMaterial = new THREE.MeshBasicMaterial({
            color: 0xffcc66, // Brighter amber for visibility at small size
            transparent: true,
            opacity: 1.0 // Full opacity for tiny dot
        });
        const packet = new THREE.Mesh(packetGeometry, packetMaterial);
        packet.position.copy(current);
        
        // Create trail (line from tail to head) - fewer segments for smoothness
        const trailPoints = [];
        const segments = 20; // More segments for smoother curves
        
        for (let i = 0; i <= segments; i++) {
            const t = tTail + (tHead - tTail) * (i / segments);
            trailPoints.push(flight.curve.getPoint(t));
        }
        
        const trailGeometry = new THREE.BufferGeometry().setFromPoints(trailPoints);
        
        // Gradient material for trail (fade from bright to transparent)
        const trailMaterial = new THREE.LineBasicMaterial({
            color: 0xffa64d, // Warm amber trail
            transparent: true,
            opacity: 0.4, // Very subtle
            linewidth: 1
        });
        
        const trailLine = new THREE.Line(trailGeometry, trailMaterial);
        globeVisual.add(trailLine);
        
        // Create packet sphere
        const packetSphere = new THREE.Mesh(packetGeometry, packetMaterial);
        packetSphere.position.copy(current);
        globeVisual.add(packetSphere);
        
        // Store references for cleanup
        flight.trail = trailLine;
        flight.line = packetSphere as any; // Store as sphere mesh
    });
    
    // Remove completed flights (when tTail >= 1) - BRUTAL FILTER
    flights = flights.filter(f => {
        const tTail = Math.max(0, f.progress - TRAIL_LENGTH);
        return tTail < 1;
    });
};

// Ramp up density over time - DISABLED (using hard cap instead)
// Removed to prevent performance issues

const init = () => {
    if (!containerRef.value) return;

    // SCENE
    scene = new THREE.Scene();
    scene.background = null;

    // CAMERA
    camera = new THREE.PerspectiveCamera(75, containerRef.value.clientWidth / containerRef.value.clientHeight, 0.1, 1000);
    camera.position.z = 2.2;

    // RENDERER
    renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
    renderer.setSize(containerRef.value.clientWidth, containerRef.value.clientHeight);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    containerRef.value.appendChild(renderer.domElement);

    // GEOMETRY
    const geometry = new THREE.IcosahedronGeometry(1.2, 5);
    
    // Visual Wireframe
    const wireframeGeometry = new THREE.WireframeGeometry(geometry);
    const material = new THREE.LineBasicMaterial({
        color: 0xf97316, // Start Orange
        transparent: true,
        opacity: 0.8,
        linewidth: 1
    });
    globeVisual = new THREE.LineSegments(wireframeGeometry, material);
    scene.add(globeVisual);

    // EVENTS
    window.addEventListener('mousemove', onMouseMove);

    // ResizeObserver
    const resizeObserver = new ResizeObserver(() => {
        onWindowResize();
    });
    resizeObserver.observe(containerRef.value);

    animate();
    
    // Loading Transition
    setTimeout(() => {
        startTransition();
    }, 1200);
    
    // Start flight system after transition
    setTimeout(() => {
        flightInterval = window.setInterval(() => {
            spawnFlight();
        }, 1500); // Spawn attempt every 1.5 seconds
    }, 1500);
};

const startTransition = () => {
    isTransitioning.value = true;
    
    const mat = globeVisual.material as THREE.LineBasicMaterial;
    mat.color.setHex(0x334155); // Slate gray - more visible
    mat.opacity = 0.35; // Increased opacity for better visibility
};

const onMouseMove = (event: MouseEvent) => {
    if (!containerRef.value) return;
    const rect = containerRef.value.getBoundingClientRect();
    mouse.x = ((event.clientX - rect.left) / rect.width) * 2 - 1;
    mouse.y = -((event.clientY - rect.top) / rect.height) * 2 + 1;
};

const animate = () => {
    animationId = requestAnimationFrame(animate);

    // Update all flights
    updateFlights();

    // ROTATION PHYSICS
    const currentScrollY = scrollY.value;
    const scrollDelta = currentScrollY - lastScrollY;
    lastScrollY = currentScrollY;

    rotationVelocity += scrollDelta * 0.0005;
    rotationVelocity += (BASE_SPEED - rotationVelocity) * 0.05;

    globeVisual.rotation.y += rotationVelocity;
    
    // MOUSE STEERING
    const targetX = mouse.y * 0.5;
    
    globeVisual.rotation.x += (targetX - globeVisual.rotation.x + (currentScrollY * 0.0002)) * 0.05;

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
    
    // Clear intervals
    if (flightInterval) clearInterval(flightInterval);
    
    // Cleanup flights
    flights.forEach((flight: Flight) => {
        if (flight.line) {
            if (globeVisual) globeVisual.remove(flight.line);
            if ('geometry' in flight.line) {
                (flight.line.geometry as THREE.BufferGeometry)?.dispose();
            }
            if ('material' in flight.line) {
                const mat = flight.line.material as THREE.Material;
                mat?.dispose();
            }
        }
        if (flight.trail) {
            if (globeVisual) globeVisual.remove(flight.trail);
            flight.trail.geometry.dispose();
            (flight.trail.material as THREE.Material).dispose();
        }
    });
    
    if (renderer) renderer.dispose();
});
</script>

<template>
    <div ref="containerRef" class="w-full h-full pointer-events-none"></div>
</template>
