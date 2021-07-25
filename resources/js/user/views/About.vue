<template>
    <div>
        <div class="fixed">
            <nav-header id="header" :on-main-page="false"></nav-header>
        </div>
        <div class="menu-content">
            <div class="about">
                <h1 class="about-title">О компании</h1>
                <div class="about-body">
                    <div class="block">
                        <img src="/images/about-1.png" alt="" class="block-img">
                        <span class="block-text">
                        Если жить только для себя, своими мелкими заботами о собственном благополучии, то от прожитого не останется и следа.
                        Если же жить для других, то другие сберегут то, чему служил, чему отдавал силы. Можно по-разному определять цель своего.
                    </span>
                    </div>
                    <div class="block">
                        <img src="/images/about-2.png" alt="" class="block-img">
                        <span class="block-text">
                        Если жить только для себя, своими мелкими заботами о собственном благополучии, то от прожитого не останется и следа.
                        Если же жить для других, то другие сберегут то, чему служил, чему отдавал силы. Можно по-разному определять цель своего.
                    </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Header from "../components/Header";

export default {
    name: "About",
    components: {
        'nav-header': Header,
    },
}
</script>

<style scoped>
.about {
    padding: 0 10px;
    margin-bottom: 32px;
}

.about-title {
    margin-top: 50px;
    font-size: 1.4rem;
    line-height: 20px;
}

.about-body {
    display: flex;
    flex-direction: column;
}

.block {
    margin: 10px 0;
}

.block-text {
    display: inline;
}

.block:nth-child(1) .block-img {
    float: right;
    margin-left: 10px;
}

.block:nth-child(2) .block-img {
    float: left;
    margin-right: 10px;
}

</style>
