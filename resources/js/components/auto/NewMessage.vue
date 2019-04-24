<template>
    <div>
        <editor-menu-bar v-if="editable" :editor="editor" class="mb-1">
            <div class="menubar" slot-scope="{ commands, isActive }">
                <button
                    type="button"
                    class="button"
                    @click="commands.variable"
                >
                    <i class="fas fa-plus-square"></i>
                    Variable
                </button>

                <button
                    type="button"
                    class="button"
                    :class="{ 'is-active': isActive.bold() }"
                    @click="commands.bold"
                >
                    <i class="fas fa-bold"></i>
                </button>

                <button
                    type="button"
                    class="button"
                    :class="{ 'is-active': isActive.italic() }"
                    @click="commands.italic"
                >
                    <i class="fas fa-italic"></i>
                </button>

                <button
                    type="button"
                    class="button"
                    :class="{ 'is-active': isActive.strike() }"
                    @click="commands.strike"
                >
                    <i class="fas fa-strikethrough"></i>
                </button>

                <button
                    type="button"
                    class="button"
                    :class="{ 'is-active': isActive.underline() }"
                    @click="commands.underline"
                >
                    <i class="fas fa-underline"></i>
                </button>

                <button
                    type="button"
                    class="button"
                    :class="{ 'is-active': isActive.code() }"
                    @click="commands.code"
                >
                    <i class="fas fa-code"></i>
                </button>

                <button
                    type="button"
                    class="button"
                    :class="{ 'is-active': isActive.heading({ level: 1 }) }"
                    @click="commands.heading({ level: 1 })"
                >
                    <i class="fas fa-heading"></i>1
                </button>

                <button
                    type="button"
                    class="button"
                    :class="{ 'is-active': isActive.heading({ level: 2 }) }"
                    @click="commands.heading({ level: 2 })"
                >
                    <i class="fas fa-heading"></i>2
                </button>

                <button
                    type="button"
                    class="button"
                    :class="{ 'is-active': isActive.heading({ level: 3 }) }"
                    @click="commands.heading({ level: 3 })"
                >
                    <i class="fas fa-heading"></i>3
                </button>

                <button
                    type="button"
                    class="button"
                    :class="{ 'is-active': isActive.bullet_list() }"
                    @click="commands.bullet_list"
                >
                    <i class="fas fa-list-ul"></i>
                </button>

                <button
                    type="button"
                    class="button"
                    :class="{ 'is-active': isActive.ordered_list() }"
                    @click="commands.ordered_list"
                >
                    <i class="fas fa-list-ol"></i>
                </button>

                <button
                    type="button"
                    class="button"
                    :class="{ 'is-active': isActive.blockquote() }"
                    @click="commands.blockquote"
                >
                    <i class="fas fa-quote-right"></i>
                </button>

                <button
                    type="button"
                    class="button"
                    @click="commands.undo"
                >
                    <i class="fas fa-undo"></i>
                </button>

                <button
                    type="button"
                    class="button"
                    @click="commands.redo"
                >
                    <i class="fas fa-redo"></i>
                </button>
            </div>
        </editor-menu-bar>

        <div class="input">
            <editor-content :editor="editor" />
        </div>

    </div>
</template>

<script>
    import {
        Editor, EditorContent, EditorMenuBar
    } from 'tiptap'

    import {
        Blockquote,
        CodeBlock,
        HardBreak,
        Heading,
        OrderedList,
        BulletList,
        ListItem,
        TodoItem,
        TodoList,
        Bold,
        Code,
        Italic,
        Link,
        Strike,
        Underline,
        History,
    } from 'tiptap-extensions'

    export default {
        components: {
            EditorContent,
            EditorMenuBar
        },

        props: ['value', 'editable'],

        data() {
            return {
                editor: new Editor({
                    extensions: [
                        new Blockquote(),
                        new CodeBlock(),
                        new HardBreak(),
                        new Heading({ levels: [1, 2, 3] }),
                        new BulletList(),
                        new OrderedList(),
                        new ListItem(),
                        new TodoItem(),
                        new TodoList(),
                        new Bold(),
                        new Code(),
                        new Italic(),
                        new Link(),
                        new Strike(),
                        new Underline(),
                        new History(),
                        new VariableNode(),
                    ],
                    editable: this.editable,
                    content: this.value,
                    onUpdate: ({ getHTML, getJSON }) => {
                        this.$emit('input', getHTML())
                    }
                }),
            }
        },

        computed: {
            //
        },

        methods: {
            //
        },

        mounted() {
            // this.editor = new Editor({
            //     content: '<p>This is just a boring paragraph</p>',
            // })
        },

        beforeDestroy() {
            this.editor.destroy()
        },
    }

    // ---------------------------------------------------
    // Variable Node for tiptap
    // ---------------------------------------------------

    import { Node } from 'tiptap'
    import { wrapIn } from 'tiptap-commands'

    class VariableNode extends Node {

        get name() {
            return 'variable'
        }

        get schema() {
            return {
                attrs: {
                    variable: { default: 'name' },
                    alternate: { default: '' },
                },
                group: 'inline',
                inline: true,
                selectable: false,
                toDOM: node => [
                    'var',
                    {
                        'data-variable': node.attrs.variable,
                        'data-alternate': node.attrs.alternate,
                    },
                    // node.attrs.variable.trim() + (node.attrs.alternate ? ' or ' + node.attrs.alternate.trim() : '')
                ],
                parseDOM: [{
                    tag: 'var',
                    getAttrs: dom => ({
                        variable: dom.getAttribute('data-variable').trim(),
                        alternate: dom.getAttribute('data-alternate') ? dom.getAttribute('data-alternate').trim() : null,
                    }),
                }],
            }
        }

        commands({ type }) {
            return () => (state, dispatch) => {
                const { selection } = state
                const position = selection.$cursor ? selection.$cursor.pos : selection.$to.pos
                const node = type.create()
                const transaction = state.tr.insert(position, node)
                dispatch(transaction)
            }
        }

        get view() {
            return {
                props: ['node', 'updateAttrs', 'editable'],
                data() {
                    return {
                        variable: this.node.attrs.variable,
                        alternate: this.node.attrs.alternate,
                        editing: false,
                        variables: ['name', 'email', 'phone'],
                    }
                },
                methods: {
                    save() {
                        this.editing = false

                        this.updateAttrs({
                            variable: this.variable,
                            alternate: this.alternate,
                        })
                    },
                    startEditing() {
                        this.editing = true
                    },
                },

                create() {
                    this.fetchVariables()
                },

                template: `
                    <var :data-variable="variable" :data-alternate="alternate" class="inline bg-black text-white rounded cursor-pointer roman" style="white-space: initial;">

                        <span v-if="editing">
                            <select v-model="variable" class="appearance-none border border-blue-darker">
                                <option v-for="variable in variables">{{ variable }}</option>
                            </select>

                            <span>or</span>

                            <input v-model="alternate" type="text" class="rounded w-32 border border-blue-darker">

                            <button @click="save()" class="text-white">
                                <i class="fas fa-check-circle"></i>
                            </button>
                        </span>

                        <span v-if="!editing" @click="startEditing()">
                            <span class="font-bold">{{ node.attrs.variable }}</span>

                            <span v-if="alternate.length || editing">or</span>

                            <span v-if="alternate && !editing" class="font-bold">{{ '"' + alternate + '"' }}</span>
                        </span>
                    </var>
                `,
            }
        }
    }
</script>
