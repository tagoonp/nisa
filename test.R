setwd('D:/RWorkplace')
dir()
library(epicalc)
library(ggplot2)
library(tidyverse)
df <- read.csv("temp_data_20200323.csv", header = TRUE)
use(df)
df

df %>% pull(1) -> dfX
df %>% pull(2) -> dfCL
df %>% pull(3) -> dfSIR
df %>% pull(4) -> dfLCL
df %>% pull(5) -> dfLWL
df %>% pull(6) -> dfUWL
df %>% pull(7) -> dfUCL

color_group <- c("#FFD300","#A60000","#A60000","#FFD300","#FFD300")

graph1 <- ggplot(data=df, aes(x=X, y=CL, group = 1)) + geom_line(aes(x=dfX,y=dfCL), color='red', group = 1, linetype = "dashed", size=1) + 
#  geom_line(aes(x=dfX,y=dfSIR), color='blue', group = 1, size = 1) +
  geom_point(aes(x=dfX,y=dfSIR, colour=color_group), group = 3, shape = 18, size = 8) +
  labs(
    title = "SPC chart of CLABSI SIR",
    x = "Quarter of the year", 
    y = "SIR of CLABSI"
  )
print(graph1)

win.metafile(filename="temp.wmf")
plot(graph1)

dev.off()
