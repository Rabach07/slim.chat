<template>
    <div @click="$bus.$emit('conversationSelected', conversation)" class="w-full p-4 border-b hover:bg-grey-lighter cursor-pointer select-none">
        <div class="flex items-center">
            <div class="flex-1">
                {{ conversation.name }}
            </div>
            <div class="float-right select-none" :class="true ? 'text-green' : 'text-grey'">
                <i class="fas fa-circle"></i>
            </div>
        </div>
        <div class="w-full mt-2 flex text-sm">
            <div class="flex-1 truncate">
                "{{ conversation.most_recent_message.message }}"
            </div>
            <div class="ml-4 text-grey-dark">
                <ago :datetime="conversation.user_last_active" />
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['conversation'],
    }
</script>
