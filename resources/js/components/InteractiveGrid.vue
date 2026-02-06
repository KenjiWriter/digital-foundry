<script setup lang="ts">
import { onMounted, onUnmounted, ref } from 'vue';

const canvasRef = ref<HTMLCanvasElement | null>(null);
let ctx: CanvasRenderingContext2D | null = null;
let width = 0;
let height = 0;
let animationId: number;
let mouseX = -1000;
let mouseY = -1000;

// Grid Configuration
const CELL_SIZE = 40;
const POINT_RADIUS = 1.5;
const INTERACTION_RADIUS = 150;

type Point = {
    x: number;
    y: number;
    originX: number;
    originY: number;
    vx: number;
    vy: number;
};

let points: Point[] = [];

const init = () => {
    if (!canvasRef.value) return;
    const canvas = canvasRef.value;
    ctx = canvas.getContext('2d');
    
    resize();
    createPoints();
    animate();

    window.addEventListener('resize', resize);
    window.addEventListener('mousemove', handleMouseMove);
};

const resize = () => {
    if (!canvasRef.value) return;
    width = window.innerWidth;
    height = window.innerHeight;
    canvasRef.value.width = width;
    canvasRef.value.height = height;
    createPoints();
};

const createPoints = () => {
    points = [];
    const cols = Math.ceil(width / CELL_SIZE);
    const rows = Math.ceil(height / CELL_SIZE);

    for (let i = 0; i <= cols; i++) {
        for (let j = 0; j <= rows; j++) {
            const x = i * CELL_SIZE;
            const y = j * CELL_SIZE;
            points.push({
                x,
                y,
                originX: x,
                originY: y,
                vx: 0,
                vy: 0
            });
        }
    }
};

const handleMouseMove = (e: MouseEvent) => {
    // Relative to canvas if needed, but fixed fullscreen usually means clientX/Y
    mouseX = e.clientX;
    mouseY = e.clientY;
};

const animate = () => {
    if (!ctx) return;
    ctx.clearRect(0, 0, width, height);

    // Physics Update
    for (const p of points) {
        // Distance from mouse
        const dx = mouseX - p.x;
        const dy = mouseY - p.y;
        const dist = Math.sqrt(dx * dx + dy * dy);

        // Interaction (Repel / Dissolve)
        if (dist < INTERACTION_RADIUS) {
            const force = (INTERACTION_RADIUS - dist) / INTERACTION_RADIUS;
            const angle = Math.atan2(dy, dx);
            const repelForce = 50 * force; // Strength

            p.vx -= Math.cos(angle) * repelForce * 0.1;
            p.vy -= Math.sin(angle) * repelForce * 0.1;
        }

        // Return to origin (Spring)
        const ox = p.originX - p.x;
        const oy = p.originY - p.y;
        p.vx += ox * 0.05;
        p.vy += oy * 0.05;

        // Damping
        p.vx *= 0.9;
        p.vy *= 0.9;

        // Apply
        p.x += p.vx;
        p.y += p.vy;
    }

    // Draw
    drawGrid();
    
    animationId = requestAnimationFrame(animate); 
};

const drawGrid = () => {
    if (!ctx) return;
    
    // Draw Lines
    ctx.beginPath();
    ctx.strokeStyle = 'rgba(128, 128, 128, 0.05)'; // Very faint
    
    // Simplistic line drawing (connecting neighbors is expensive O(N^2) or O(N*4))
    // Optimized: Re-calculate grid structure or just draw points.
    // Task says: "Grid lines float gently" and "dissolve/separate".
    // Drawing actual lines between moving points is expensive. 
    // Let's draw dots and short lines or just dots for "Matrix data stream" vibe.
    
    // Actually, let's draw lines to immediate right and bottom neighbors if they are close enough
    // We can pre-calculate neighbors or use index arithmetic since we created them in a grid loop.
    
    const cols = Math.ceil(width / CELL_SIZE) + 1;
    
    for (let i = 0; i < points.length; i++) {
        const p = points[i];
        
        // Draw Point
        /*
        ctx.fillStyle = 'rgba(100, 100, 100, 0.2)';
        ctx.beginPath();
        ctx.arc(p.x, p.y, 1, 0, Math.PI * 2);
        ctx.fill();
        */

        // Connect to Right Neighbor
        // index + 1, check if not last in row
        // Actually, logic is cleaner if we just iterate loops again but accessing linear array is faster.
        // Let's trust the "dissolve" effect on points/lines.
        
        // Let's just draw faint lines using the physics-affected positions.
        // To be fast, we only draw lines if we are confident of neighbor index.
    }
    
    // Re-looping with grid logic for lines
     const numCols = Math.ceil(width / CELL_SIZE) + 1;
     const numRows = Math.ceil(height / CELL_SIZE) + 1; // Approximate
     
     // Drawing lines is tricky with physics because topology changes visually if we just link by index.
     // But linking by index is the "Net" effect.
     
     ctx.beginPath();
     for (let i = 0; i < points.length; i++) {
         const p = points[i];
         const rightIndex = i + (Math.floor(i / numCols) === Math.floor((i + 1) / numCols) ? 1 : -1); 
         // Actually simpler:
         
         // Horizontal Line
         if ((i + 1) % numCols !== 0 && (i + 1) < points.length) {
             const right = points[i + 1];
             if (distSq(p, right) < CELL_SIZE * CELL_SIZE * 4) { // Only draw if not stretched too far (break effect)
                 ctx.moveTo(p.x, p.y);
                 ctx.lineTo(right.x, right.y);
             }
         }
         
         // Vertical Line
         if (i + numCols < points.length) {
             const bottom = points[i + numCols];
             if (distSq(p, bottom) < CELL_SIZE * CELL_SIZE * 4) {
                 ctx.moveTo(p.x, p.y);
                 ctx.lineTo(bottom.x, bottom.y);
             }
         }
     }
     ctx.stroke();
};

const distSq = (p1: Point, p2: Point) => {
    return (p1.x - p2.x) ** 2 + (p1.y - p2.y) ** 2;
};

onMounted(() => {
    init();
});

onUnmounted(() => {
    window.removeEventListener('resize', resize);
    window.removeEventListener('mousemove', handleMouseMove);
    cancelAnimationFrame(animationId);
});
</script>

<template>
    <canvas ref="canvasRef" class="absolute inset-0 z-0 pointer-events-none"></canvas>
</template>
