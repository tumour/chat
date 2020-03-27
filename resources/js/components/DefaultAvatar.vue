<template>
    <svg height="48" width="48">
        <circle :fill="color" cx="24" cy="24" r="24"></circle>
        <text
            fill="#ffffff"
            font-size="24"
            text-anchor="middle"
            x="24"
            y="32">{{ getImageLetters(svgText) }}</text>
    </svg>
</template>

<script>
    export default {
        props: {
            svgText: {
                type: String,
                required: true
            },
            color: {
                type: String,
                required: true
            }
        },
        methods: {
            getImageLetters(name) {
                let imageLetters = name[0];

                let split = name.split(' ');
                if (split.length === 2) {
                    imageLetters = split[0][0] + split[1][0];
                }

                return imageLetters.toUpperCase();
            }
        }
    }
</script>
